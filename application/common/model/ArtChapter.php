<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:17
 */

namespace app\common\model;


use think\Model;
use tree\Tree;

class ArtChapter extends Model
{
    /**在线文档分类列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function menuList($id = '',$field = true)
    {
        $tree = new Tree();
        $tree::$treeList = [];
        $list = ArtChapter::wherenull('delete_time')->field($field)->order('pid asc,sort asc')->select();
        return $tree->tree($list,'00000000-0000-0000-0000-000000000000',0,'&nbsp;&nbsp;&nbsp;&nbsp;');
    }

    /** 获取单个在线文档分类信息
     * @param $pid
     * @return mixed
     */
    public function menuInfo($pid)
    {
        return ArtChapter::where('ID',$pid)->find();
    }

    /**添加或更新在线文档分类
     * @param $params
     * @return bool
     */
    public function updateMenu($params)
    {
        if(empty($params['id'])){
            $params['create_time'] = time();
            $result = ArtChapter::allowField(true)->save($params);
            if($result){
                $contents = '添加在线分档分类:'.$params['cname'].',ID:'.$params['ID'];
                sysLogs($contents);
            }
        }else{
            $result = ArtChapter::allowField(true)->isUpdate(true)->save($params);
            if($result){
                $contents = '更新在线分档分类:'.$params['cname'].',ID:'.$params['id'];
                sysLogs($contents);
            }
        }
        return $result;
    }

    /**禁用在线文档分类
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $name = ArtChapter::where('ID',$id)->value('cname');
        $res = ArtChapter::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用在线文档分类:'.$name.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用在线文档分类
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $name = ArtChapter::where('ID',$id)->value('cname');
        $res = ArtChapter::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用在线文档分类:'.$name.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除在线文档分类
     * @param $ids
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delMenu($ids)
    {
        $map = ['id' => $ids];
        $name = ArtChapter::where('ID','in',$ids)->column('cname');
        $result = ArtChapter::where($map)->update([
            'delete_time'=>time(),
            'status'=>0,
        ]);
        if($result){
            $contents = '删除在线文档分类:'.join(',',$name).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

}