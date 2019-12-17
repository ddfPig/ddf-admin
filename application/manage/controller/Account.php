<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 18:43
 */

namespace app\manage\controller;


use app\common\logic\AccountLogic;
use app\common\model\AuthGroup;
use app\common\model\AuthGroupAccess;
use app\common\validate\AdminValidate;
use think\Request;

class Account extends Base
{
    /**用户管理员列表
     * @return mixed
     */
    public function index()
    {
        $accountLogic = new AccountLogic();
        $listInfo = $accountLogic->accountList();
        $this->assign('list', $listInfo);
        return $this->fetch();
    }

    /**添加操作管理人员
     * @param Request $request
     * @return mixed|void
     */
    public function newAccount(Request $request)
    {
        if($request->isPost()){
             $params = $request->post();
             $params['ID'] = $this->uuid();
             //验证参数
             $validate = new AdminValidate();
             if(!$validate->scene('add')->check($params)){
                  $error = $validate->getError();
                  return $this->sendData($error,0);
             }
             //管理人员添加操作
             $accountLogic = new AccountLogic();
             return $accountLogic->updateAdmin($params);
        }else{
            $roles = AuthGroup::where('status',1)->whereNull('delete_time')->select();
            $this->assign('roles',$roles);
            return $this->fetch('addAccount');
        }

    }

    /**修改管理操作人员
     * @param Request $request
     * @return array|mixed
     */
    public function updateAccount(Request $request)
    {
        $accountLogic = new AccountLogic();
        $params = $request->post();
        if($request->isPost()){
            unset($params['userpass']);
            //验证参数
            $validate = new AdminValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }
            //管理人员添加操作
            return $accountLogic->updateAdmin($params);
        }else{
            $id = $request->param('id');
            $info = $accountLogic->getAdminOne($id);
            $roles = AuthGroup::where('status',1)->whereNull('delete_time')->select();
            $auth_group_access=AuthGroupAccess::where(array('userid'=>$info['ID']))->value('group_id');
            $this->assign('auth_group_access',$auth_group_access);
            $this->assign('roles',$roles);
            $this->assign('info',$info);
            return $this->fetch('addAccount');
        }
    }

    /**管理操作人员状态
     * @param Request $request
     * @return array
     */
    public function setForbidden(Request $request)
    {
         if($request->isGet()){
             $params = $request->param();
             //修改状态逻辑
             $accountLogic = new AccountLogic();
             return $accountLogic->setStatus($params);
         }
    }

    /**删除管理人员
     * @param Request $request
     * @return array
     */
    public function delAccount(Request $request)
    {
          $idArray = array_unique((array)$this->request->param('id'));
          if (empty($idArray) ) {
              return $this->sendData('请选择要操作的数据',0);
          }
          //删除管理人员逻辑
          $accountLogic = new AccountLogic();
          return $accountLogic->deleteAdmin($idArray);
    }

    /**修改管理人员密码
     * @param Request $request
     * @return array
     */
    public function modifyPass(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            //验证参数
            $validate = new AdminValidate();
            if(!$validate->scene('pass')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }
            //修改密码逻辑
            $accountLogic = new AccountLogic();
            return $accountLogic->updateAdmin($params);
        }
    }

}