<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 16:02
 */

namespace app\manage\controller;


use app\common\logic\RuleLogic;
use app\common\model\AuthRule;
use app\common\validate\RuleValidate;
use think\Request;
use tree\Tree;

class Rule extends Base
{
    /**权限菜单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
     public function index()
     {
         $rule = new RuleLogic();
         $info = $rule->ruleList();
         $this->assign('list',$info);
         return $this->fetch();
     }

    /**添加与修改权限规则
     * @param Request $request
     * @return array|mixed
     */
     public function newRule(Request $request)
     {
         $params = $request->post();
         $pid = $request->param('pid','00000000-0000-0000-0000-000000000000');
         $ruleLogic = new RuleLogic();
          if($request->isPost()){
              if(\Tool::startLocker('lock')){
                  $params['ID'] = $this->uuid();
                  //权限编号设置
                  $num = AuthRule::order('create_time desc')->limit(1)->value('num');
                  if($num){
                      $num = $num + 1;
                  }else{
                      $num = 1;
                  }
                  $params['num'] = $num;

                  $level = AuthRule::where('pid',$pid)->value('level');
                  $params['level']=$level+1;
                  $params['pid']=$pid;
                  //验证参数
                  $validate = new RuleValidate();
                  if(!$validate->scene('add')->check($params)){
                      $error = $validate->getError();
                      return $this->sendData($error,0);
                  }

                  //权限规则添加操作
                  return $ruleLogic->updateRule($params);
                  \Tool::endLockers('lock');
              }

          }else{
              $cate = [];
              if($pid && $pid != '00000000-0000-0000-0000-000000000000'){
                  /* 获取上级栏目信息 */
                  $cate = $ruleLogic->ruleInfo($pid);
                  if(!($cate && 1 == $cate['status'])){
                      return $this->sendData('指定的上级栏目不存在或被禁用',0);
                  }
              }

              $this->assign('pid',$pid);
              $this->assign('category',$cate);
              return $this->fetch('updateRule');
          }
     }

    /** 修改权限规则
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
     public function updateRule(Request $request)
     {
         $params = $request->post();
         $id = $request->param('id','00000000-0000-0000-0000-000000000000');
         $ruleLogic = new RuleLogic();
         if($request->isPost()){
             if(\Tool::startLocker('lock')){
                 //验证参数
                 $validate = new RuleValidate();
                 if(!$validate->scene('edit')->check($params)){
                     $error = $validate->getError();
                     return $this->sendData($error,0);
                 }
                 //权限规则修改操作
                 return $ruleLogic->updateRule($params);
                 \Tool::endLockers('lock');
             }

         }else{
             $info=$ruleLogic->ruleInfo($id);
             $cate = $ruleLogic->ruleInfo($info['pid']);
             $this->assign('info',$info);
             $this->assign('pid',$info['pid']);
             $this->assign('category',$cate);
             return $this->fetch('updateRule');
         }
     }

    /**设置权限规则状态
     * @param Request $request
     */
     public function setStatus(Request $request)
     {
         if($request->isGet()){
             $params = $request->param();
             //修改状态逻辑
             $rule = new RuleLogic();
             return $rule->setStatus($params);
         }
     }

    /**删除权限规则
     * @param Request $request
     * @return array
     */
     public function delRule(Request $request)
     {
         $idArray = array_unique((array)$this->request->param('id'));
         //检测该权限下是否有子级
         $child = AuthRule::where('pid','in',$idArray)->whereNull('delete_time')->find();
         if($child){
              return $this->sendData('请先删除子级',0);
         }
         if (empty($idArray) ) {
             return $this->sendData('请选择要操作的数据',0);
         }
         //删除权限规则逻辑
         $rule = new RuleLogic();
         return $rule->deleteRole($idArray);
     }

    /**权限规则的移动与合并
     * @param Request $request
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function operate(Request $request){

        $type = $request->param('type','move');
        //检查操作参数
        if(strcmp($type, 'move') == 0){
            $operate = '移动';
        }elseif(strcmp($type, 'merge') == 0){
            $operate = '合并';
        }else{
            return $this->sendData('参数错误！',0);
        }
        $from = $request->param('from');
        empty($from) &&  $this->sendData('参数错误！',0);
        //获取分类
        $map = [['status','=',1], ['ID','<>',$from]];
        $list = AuthRule::where($map)->field('ID,pid,title')->order('pid asc,ID asc,sort asc')->select();
        $Tree = new Tree();
        $this->assign('type', $type);
        $this->assign('from', $from);
        $this->assign('operate', $operate);
        $this->assign('title',AuthRule::where('ID',$from)->value('title'));
        $this->assign('list', $Tree->tree($list));
        return $this->fetch();
    }

    /**
     * 移动分类
     */
    public function move(Request $request){
        $to = $request->post('to');
        $from = $request->post('from');
        $res = AuthRule::where(['ID'=>$from])->setField('pid', $to);
        if($res !== false){
            $fromName = AuthRule::where('ID',$from)->value('title');
            $toName = AuthRule::where('ID',$to)->value('title');
            $contents = '权限规则移动:'.$fromName.' 移动到 '.$toName.'分类下,ID:'.$from.' 移动到 '.$from;
            sysLogs($contents);
            return $this->sendData('操作成功！',1);
        }else{
            return $this->sendData('操作失败！',0);
        }
    }

    /**
     * 合并分类

    public function merge(){
        $to = $this->request->post('to');
        $from = $this->request->post('from');
        //合并文档
        // $res = Db::name('Novel')->where(['category'=>$from])->setField('category', $to);
        if($res){
            //删除被合并的分类
            Db::name('Category')->delete($from);
            $this->success('合并分类成功！');
        }else{
            $this->error('合并分类失败！');
        }

    }
     */



}