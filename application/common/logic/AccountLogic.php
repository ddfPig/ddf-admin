<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 18:50
 */

namespace app\common\logic;


use app\common\model\Admin;
use app\manage\controller\Base;

class AccountLogic extends Base
{

    /**操作管理人员列表
     * @return \think\Paginator
     */
    public function accountList()
    {
        $admin = new Admin();
        return $admin->accountList();
    }

    /**获取单个操作人员的信息
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAdminOne($id)
    {
        $admin = new Admin();
        return $admin->accountListOne($id);
    }

    /**添加管理人员
     * @param $params
     */
    public function updateAdmin($params)
    {
        $admin = new Admin();
        $result = $admin->updateAdmin($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置管理操作人员状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Admin::where('ID',$params['id'])->value('status');
        $admin = new Admin();
        if($status==1){
            $result = $admin->forbid($params['id']);
        }else{
            $result = $admin->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除管理人员
     * @param $params
     * @return array
     */
    public function deleteAdmin($params)
    {
        $admin = new Admin();
        $result = $admin->deleteAdmin($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }





}