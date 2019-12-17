<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 17:15
 */

namespace app\common\model;


use Ramsey\Uuid\Uuid;
use think\Model;
class Admin extends Model
{

    /**登录时获取用户信息验证
     * @param $username
     * @return mixed
     */
    public function getAdmin($field,$username)
    {
        $fields = "a.ID,a.username,a.sessionID,a.userpass,a.email,a.mobile,a.firstime,a.lastime,a.ip,a.status,c.gname,c.status AS gstatus";
        return Admin::alias('a')->field($fields)->join('sunny_auth_group_access b','a.ID = b.userid')->join('sunny_auth_group c','b.group_id = c.ID')->where($field,$username)->findOrEmpty();
    }

    /**管理员操作人员列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function accountList()
    {
        return Admin::where('username','<>','adminxzc')->whereNull('delete_time')->paginate(config('web.list_rows'));
    }

    /**获取某个操作人员的个人信息
     * @param $params
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function accountListOne($id)
    {
        return Admin::where('ID',$id)->find();
    }

    /**添加与修改管理人员
     * @param $params
     * @return bool
     */
    public function updateAdmin($params)
    {
        $access = new AuthGroupAccess();
         if(empty($params['id'])){
             $userpass = password_hash($params['userpass'],PASSWORD_DEFAULT);
             $params['userpass'] = $userpass;
             $params['create_time'] = time();
             $result = Admin::allowField(true)->save($params);
             if($result){
                 $group = [
                     'ID'=>Uuid::uuid1(),
                     'userid'=>$params['ID'],
                     'group_id'=>$params['gid']
                 ];

                 $access->allowField(true)->insert($group);
                 $contents = '添加管理员名称:'.$params['username'].',ID:'.$params['ID'];
                 sysLogs($contents);
             }

         }else{
             if(!empty($params['userpass'])){
                 $userpass = password_hash($params['userpass'],PASSWORD_DEFAULT);
                 $params['userpass'] = $userpass;
             }
             $result = Admin::allowField(true)->isUpdate(true)->save($params);

             $group_id=isset($params['gid'])?$params['gid']:'';
             if($group_id){
                 $rst=$access->where(array('userid'=>$params['id']))->find();
                 if($rst){
                     //修改
                     $access->where(array('userid'=>$params['id']))->setField('group_id',$group_id);
                 }else{
                     //增加
                     $data['ID']=Uuid::uuid1();
                     $data['userid']=$params['id'];
                     $data['group_id']=$group_id;
                     $access->allowField(true)->save($data);
                 }
             }

             if($result){
                 $contents = '更新管理员名称:'.$params['username'].',ID:'.$params['id'];
                 sysLogs($contents);
             }

         }
        return $result;
    }

    /**禁用管理操作人员
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $username = Admin::where('ID',$id)->value('username');
        $res =  Admin::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用管理员:'.$username.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用管理操作人员
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $username = Admin::where('ID',$id)->value('username');
        $res =  Admin::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用管理员:'.$username.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除管理员
     * @param $ids
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
   public function deleteAdmin($ids)
   {
       $map = ['id' => $ids];
       $username = Admin::where('ID','in',$ids)->column('username');
       $result = Admin::where($map)->update([
           'delete_time'=>time(),
           'status'=>0,
       ]);
       if($result){
           $contents = '删除管理员:'.join(',',$username).',ID:'.join(',',$ids);
           sysLogs($contents);
       }
       return $result;
   }









}