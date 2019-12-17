<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 13:04
 */

namespace app\common\model;


use think\Model;

class AuthGroup extends Model
{
    /**用户组角色列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function roleList()
    {   //where('gcode','<>','cj')->
        return AuthGroup::where('gcode','<>','cj')->whereNull('delete_time')
                          ->order('create_time desc')
                          ->paginate(config('web.list_rows'));
    }

    /**获取角色单个信息
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRoleOne($id)
    {
        return AuthGroup::where('ID',$id)->find();
    }

    /**修改或添加角色
     * @param $params
     * @return bool
     */
    public function updateRole($params)
    {
        if(empty($params['id'])){
            $params['create_time'] = time();
            $result = AuthGroup::allowField(true)->save($params);
            if($result){
                $contents = '添加角色名称:'.$params['gname'].',ID:'.$params['ID'];
                sysLogs($contents);
            }

        }else{
            $result = AuthGroup::allowField(true)->isUpdate(true)->save($params);
            if($result){
                $contents = '更新角色名称:'.$params['gname'].',ID:'.$params['id'];
                sysLogs($contents);
            }

        }
        return $result;
    }

    /**禁用角色人员
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $gname = AuthGroup::where('ID',$id)->value('gname');
        $res = AuthGroup::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用角色:'.$gname.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用角色人员
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $gname = AuthGroup::where('ID',$id)->value('gname');
        $res =  AuthGroup::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用角色:'.$gname.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除角色人员
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteRole($ids)
    {
        $map = ['id' => $ids];
        $gname = AuthGroup::where('ID','in',$ids)->column('gname');
        $result = AuthGroup::where($map)->update([
            'delete_time'=>time(),
            'status'=>0,
        ]);
        if($result){
            $contents = '删除角色:'.join(',',$gname).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }



}