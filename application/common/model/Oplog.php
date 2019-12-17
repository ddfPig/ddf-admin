<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 10:28
 */

namespace app\common\model;


use think\Model;

class Oplog extends Model
{
    /**添加日志
     * @param $log
     * @return bool
     */
    public function add($log)
    {
        return Oplog::allowField(true)->save($log);
    }

    /**
     * 日志列表
     */
    public function logList($request)
    {
        $map = [];
        $keywords = $request->param('keywords','');
        if($keywords){
            $map[]  = ['contents','like','%'.$keywords.'%'];
        }
        $start = strtotime($request->param('start'));
        $end = strtotime($request->param('end').' 23:55:55');

        if($start && $end){
            $map[]  = ['optime','between',[$start,$end]];
        }

        $field = "ID,operationName,contents,IP,optime";
        $list = Oplog::field($field)
                        ->where($map)
                        ->wherenull('delete_time')
                        ->order('optime desc')
                        ->paginate(config('web.list_rows'));
        return $list;
    }

    /**删除日志
     * @param $ids
     * @return int|string
     * @throws \Exception
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteLogs($ids)
    {
        $map = ['id' => $ids];
        $result = Oplog::where($map)->update([
            'delete_time'=>time(),
        ]);
        return $result;
    }
}