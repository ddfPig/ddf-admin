<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:16
 */

namespace app\manage\controller;


use app\common\logic\HcateLogic;
use app\common\model\ArtChapter;
use app\common\validate\HcateValidate;
use think\Request;
use tree\Tree;

class Helpcate extends Base
{
    /**在线文档分类列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $hcate = new HcateLogic();
        $info = $hcate->menuList();
        $this->assign('list',$info);
        return $this->fetch();
    }

    /**添加在线文档分类
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function newMenu(Request $request)
    {
        $params = $request->post();
        $pid = $request->param('pid','00000000-0000-0000-0000-000000000000');
        $hcate = new HcateLogic();
        if($request->isPost()){
            if(\Tool::startLocker('lock')){
                $params['ID'] = $this->uuid();
                //验证参数
                $validate = new HcateValidate();
                if(!$validate->scene('add')->check($params)){
                    $error = $validate->getError();
                    return $this->sendData($error,0);
                }

                //菜单添加操作
                return $hcate->updateMenu($params);
                \Tool::endLockers('lock');
            }

        }else{
            $cate = [];
            if($pid && $pid != '00000000-0000-0000-0000-000000000000'){
                /* 获取上级栏目信息 */
                $cate = $hcate->menuInfo($pid);
                if(!($cate && 1 == $cate['status'])){
                    return $this->sendData('指定的上级菜单不存在或被禁用',0);
                }
            }

            $this->assign('pid',$pid);
            $this->assign('category',$cate);
            return $this->fetch('newMenu');
        }
    }

    /**修改在线文档分类
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function updateMenu(Request $request)
    {
        $params = $request->post();
        $id = $request->param('id','00000000-0000-0000-0000-000000000000');
        $hcate = new HcateLogic();
        if($request->isPost()){
            if(\Tool::startLocker('lock')){
                //验证参数
                $validate = new HcateValidate();
                if(!$validate->scene('edit')->check($params)){
                    $error = $validate->getError();
                    return $this->sendData($error,0);
                }
                //菜单修改操作
                return $hcate->updateMenu($params);
                \Tool::endLockers('lock');
            }

        }else{
            $info=$hcate->menuInfo($id);
            $cate = $hcate->menuInfo($info['pid']);
            $this->assign('info',$info);
            $this->assign('pid',$info['pid']);
            $this->assign('category',$cate);
            return $this->fetch('newMenu');
        }
    }

    /**设置在线文档分类状态
     * @param Request $request
     */
    public function setStatus(Request $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $hcate = new HcateLogic();
            return $hcate->setStatus($params);
        }
    }
    /**删除在线文档分类
     * @param Request $request
     * @return array
     */
    public function delMenu(Request $request)
    {
        $idArray = array_unique((array)$this->request->param('id'));
        //检测该权限下是否有子级
        $child = ArtChapter::where('pid','in',$idArray)->whereNull('delete_time')->find();
        if($child){
            return $this->sendData('请先删除子级',0);
        }
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除菜单逻辑
        $hcate = new HcateLogic();
        return $hcate->delMenu($idArray);
    }

    /**菜单在线文档分类
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
        $map = [['status','=',1], ['ID','<>',$from],['pid','=','00000000-0000-0000-0000-000000000000']];
        $list = ArtChapter::where($map)->field('ID,pid,cname')->order('pid asc,ID asc,sort asc')->select();
        $Tree = new Tree();
        $this->assign('type', $type);
        $this->assign('from', $from);
        $this->assign('operate', $operate);
        $this->assign('title',ArtChapter::where('ID',$from)->value('cname'));
        $this->assign('list', $Tree->tree($list));
        return $this->fetch();
    }

    /**
     * 移动在线文档分类操作
     */
    public function move(Request $request){
        $to = $request->post('to');
        $from = $request->post('from');
        $res = ArtChapter::where(['ID'=>$from])->setField('pid', $to);
        if($res !== false){
            $fromName = ArtChapter::where('ID',$from)->value('cname');
            $toName = ArtChapter::where('ID',$to)->value('cname');
            $contents = '移动文档分类:'.$fromName.' 移动到 '.$toName.'分类下,ID:'.$from.' 移动到 '.$from;
            sysLogs($contents);
            return $this->sendData('操作成功！',1);
        }else{
            return $this->sendData('操作失败！',0);
        }
    }
}