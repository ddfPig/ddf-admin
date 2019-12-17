<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 13:05
 */

namespace app\common\logic;


use app\common\model\AuthGroup;
use app\manage\controller\Base;

class RoleLogic extends Base
{
    /**用户组角色列表
     * @return \think\Paginator
     */
    public function roleList()
    {
        $roleModel = new AuthGroup();
        return $roleModel->roleList();
    }

    /**获取单个角色信息
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRoleOne($id)
    {
        $roleModel = new AuthGroup();
        return $roleModel->getRoleOne($id);
    }

    /**添加或修改角色
     * @param $params
     * @return array
     * @throws \Exception
     */
    public function updatRole($params)
    {
        $roleModel = new AuthGroup();
        $result = $roleModel->updateRole($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置角色状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = AuthGroup::where('ID',$params['id'])->value('status');
        $roleModel = new AuthGroup();
        if($status==1){
            $result = $roleModel->forbid($params['id']);
        }else{
            $result = $roleModel->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    public function delRole($params)
    {
        $roleModel = new AuthGroup();
        $result = $roleModel->deleteRole($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }





}