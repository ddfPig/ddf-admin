<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 16:03
 */

namespace app\common\model;


use think\Model;
use tree\Tree;

class AuthRule extends Model
{
    /**权限菜单列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
     public function ruleList($id = '',$field = true)
     {
         $tree = new Tree();
         $tree::$treeList = [];
         $list = AuthRule::wherenull('delete_time')->field($field)->order('pid asc,sort asc')->select();
         return $tree->tree($list,'00000000-0000-0000-0000-000000000000',0,'&nbsp;&nbsp;&nbsp;&nbsp;');
     }

    /** 获取单个权限规则信息
     * @param $pid
     * @return mixed
     */
     public function ruleInfo($pid)
     {
         return AuthRule::where('ID',$pid)->find();
     }

    /**添加或更新权限规则
     * @param $params
     * @return bool
     */
     public function updaterule($params)
     {
         if(empty($params['id'])){
             $params['create_time'] = time();
             $result = AuthRule::allowField(true)->save($params);
             if($result){
                 $contents = '添加权限规则:'.$params['title'].',ID:'.$params['ID'];
                 sysLogs($contents);
             }

         }else{
             $result = AuthRule::allowField(true)->isUpdate(true)->save($params);
             if($result){
                 $contents = '更新权限规则:'.$params['title'].',ID:'.$params['id'];
                 sysLogs($contents);
             }

         }
         return $result;
     }


    /**禁用权限规则
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
         $title = AuthRule::where('ID',$id)->value('title');
         $res = AuthRule::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用权限规则:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用权限规则
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $title = AuthRule::where('ID',$id)->value('title');
        $res =  AuthRule::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用权限规则:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除权限规则
     * @param $ids
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteRule($ids)
    {
        $map = ['id' => $ids];
        $title = AuthRule::where('ID','in',$ids)->column('title');
        $result = AuthRule::where($map)->update([
            'delete_time'=>time(),
            'status'=>0,
        ]);
        if($result){
            $contents = '删除权限规则:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }



}