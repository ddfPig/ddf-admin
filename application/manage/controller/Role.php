<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 12:41
 */

namespace app\manage\controller;


use app\common\logic\RoleLogic;
use app\common\model\AuthGroup;
use app\common\model\AuthRule;
use app\common\validate\RoleValidate;
use think\facade\Cache;
use think\Request;


class Role extends Base
{
    /**用户组角色列表
     * @return mixed
     */
     public function index()
     {
         $role = new RoleLogic();
         $list = $role->roleList();
         $this->assign('list', $list);
         return $this->fetch();

     }

    /**添加用户组
     * @param Request $request
     * @return mixed
     */
     public function newRole(Request $request)
     {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //角色缩写
            $params['gcode'] = \Tool::getFirst($params['gname']);
            //验证参数
            $validate = new RoleValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }
            //角色添加逻辑
            $role = new RoleLogic();
            return $role->updatRole($params);
        }else{
            return $this->fetch('updateRole');
        }
     }

    /**修改角色
     * @param Request $request
     * @return array|mixed
     */
     public function updateRole(Request $request)
     {
         $role = new RoleLogic();
         $params = $request->post();
         if($request->isPost()){
             //验证参数
             $validate = new RoleValidate();
             if(!$validate->scene('edit')->check($params)){
                 $error = $validate->getError();
                 return $this->sendData($error,0);
             }
             //角色添加逻辑
             return $role->updatRole($params);
         }else{
             $id = $request->param('id');
             $info = $role->getRoleOne($id);
             $this->assign('info',$info);
             return $this->fetch('updateRole');
         }
     }

    /**设置角色状态
     * @param Request $request
     * @return array
     */
     public function setStatus(Request $request)
     {
         if($request->isGet()){
             $params = $request->param();
             //修改状态逻辑
             $role = new RoleLogic();
             return $role->setStatus($params);
         }
     }

    /**删除角色
     * @param Request $request
     * @return array
     */
     public function delRole(Request $request)
     {
         $idArray = array_unique((array)$this->request->param('id'));
         if (empty($idArray) ) {
             return $this->sendData('请选择要操作的数据',0);
         }
         //删除管理人员逻辑
         $role = new RoleLogic();
         return $role->delRole($idArray);
     }

    /**分配权限
     * @param Request $request
     */
     public function setRule(Request $request)
     {
         //获取角色名称
         $role = AuthGroup::where('ID',$request->param('id'))->find();
         //获取权限
         $data = AuthRule::field('ID,num,link,title')->where('pid="00000000-0000-0000-0000-000000000000"')->select();
         foreach ($data as $k=>$v){
             $data[$k]['sub'] = AuthRule::field('ID,num,link,title')->where('pid',$v['ID'])->select();
             foreach ($data[$k]['sub'] as $kk=>$vv){
                 $data[$k]['sub'][$kk]['sub'] = AuthRule::field('ID,num,link,title')->where('pid',$vv['ID'])->select();
                 foreach ($data[$k]['sub'][$kk]['sub'] as $kkk=>$vvv){
                     $data[$k]['sub'][$kk]['sub'][$kkk]['sub'] = AuthRule::field('ID,num,link,title')->where('pid',$vvv['ID'])->select();
                 }
             }
         }

         //dump($data);
         $this->assign('datab',$data);
         $this->assign('role',$role);
         return $this->fetch('setRule');
     }

    /**更新权限
     * @param Request $request
     */
     public function roleRule(Request $request)
     {
         $new_rules = $request->param('rules/a');
         $imp_rules = implode(',', $new_rules).',';
         $sldata=array(
             'ruleNum'=>$imp_rules,
         );
         $result = AuthGroup::where('ID',$request->param('id'))->update($sldata);
         if($result !== false){
             Cache::clear();
             return $this->sendData('权限配置成功',1);
         }else{
             return $this->sendData('权限配置失败',0);
         }
     }
}