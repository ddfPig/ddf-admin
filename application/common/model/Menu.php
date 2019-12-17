<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 14:21
 */

namespace app\common\model;


use think\Model;
use tree\Tree;

class Menu extends Model
{
    /**门户菜单列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function menuList($id = '',$field = true)
    {
        $tree = new Tree();
        $tree::$treeList = [];
        $list = Menu::wherenull('delete_time')->field($field)->order('pid asc,sort asc')->select();
        return $tree->tree($list,'00000000-0000-0000-0000-000000000000',0,'&nbsp;&nbsp;&nbsp;&nbsp;');
    }

    /** 获取单个菜单信息
     * @param $pid
     * @return mixed
     */
    public function menuInfo($pid)
    {
        return Menu::where('ID',$pid)->find();
    }

    /**添加或更新菜单
     * @param $params
     * @return bool
     */
    public function updateMenu($params)
    {
        if(empty($params['id'])){
            $params['create_time'] = time();
            $result = Menu::allowField(true)->save($params);
            if($result){
                $contents = '添加门户菜单:'.$params['name'].',ID:'.$params['ID'];
                sysLogs($contents);
            }
        }else{
            $result = Menu::allowField(true)->isUpdate(true)->save($params);
            if($result){
                $contents = '更新门户菜单:'.$params['name'].',ID:'.$params['id'];
                sysLogs($contents);
            }
        }
        return $result;
    }

    /**禁用门户菜单
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $name = Menu::where('ID',$id)->value('name');
        $res = Menu::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用门户菜单:'.$name.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用门户菜单
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $name = Menu::where('ID',$id)->value('name');
        $res = Menu::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用门户菜单:'.$name.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除门户菜单
     * @param $ids
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delMenu($ids)
    {
        $map = ['id' => $ids];
        $name = Menu::where('ID','in',$ids)->column('name');
        $result = Menu::where($map)->update([
            'delete_time'=>time(),
            'status'=>0,
        ]);
        if($result){
            $contents = '删除门户菜单:'.join(',',$name).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }







}