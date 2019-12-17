<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-23
 * Time: 19:23
 */

namespace app\common\model;


use think\Model;

class Adtype extends Model
{

    /**广告位列表--分页
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
     public function tList($request)
     {
         return Adtype::whereNull('delete_time')->paginate(config('web.list_rows'));
     }

    /**广告位列表--无分页
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
     public function tcate()
     {
         return Adtype::whereNull('delete_time')->select();
     }

    /**单个广告信息
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

     public function adsInfo($id)
     {
         return Adtype::where('ID',$id)->find();
     }

    /**添加/修改广告位
     * @param $params
     * @return bool
     */
     public function addType($params)
     {
         if(empty($params['id'])){
             $result = Adtype::allowField(true)->save($params);
             if($result){
                 $contents = '添加广告位:'.$params['tname'].',ID:'.$params['ID'];
                 sysLogs($contents);
             }
         }else{
             $result = Adtype::allowField(true)->isUpdate(true)->save($params);
             if($result){
                 $contents = '更新广告位:'.$params['tname'].',ID:'.$params['id'];
                 sysLogs($contents);
             }
         }
         return $result;
     }

    /**删除广告位
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
     public function delType($ids)
     {
         $map = ['id' => $ids];
         $tname = Adtype::where('ID','in',$ids)->column('tname');
         $result = Adtype::where($map)->update([
             'delete_time'=>time(),
         ]);
         if($result){
             $contents = '删除广告位:'.join(',',$tname).',ID:'.join(',',$ids);
             sysLogs($contents);
         }
         return $result;
     }

}