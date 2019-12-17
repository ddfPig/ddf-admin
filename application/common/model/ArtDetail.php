<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 15:45
 */

namespace app\common\model;


use think\Model;

class ArtDetail extends Model
{
    /**在线文档附表添加数据
     * @param $params
     * @return bool
     */
    public function addDetail($params)
    {
        return ArtDetail::allowField(true)->save($params);
    }

    /**在线文档附表更新数据
     * @param mixed $id
     * @param $params
     * @return bool
     */
    public function updateDetail($id,$params)
    {
        return ArtDetail::allowField(true)->where('articleID',$id)->update($params);
    }
}