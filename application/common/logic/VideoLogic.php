<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 18:00
 */

namespace app\common\logic;


use app\common\model\Video;
use app\common\model\Vidio;
use app\manage\controller\Base;

class VideoLogic extends Base
{
    /**在线视频列表
     * @param $request
     * @return \think\Paginator
     */
    public function docList($request)
    {
        $Model = new Video();
        return $Model->docList($request);
    }

    /**回收站在线视频
     * @param $request
     * @return \think\Paginator
     */
    public function docListBack($request)
    {
        $Model = new Video();
        return $Model->docListBack($request);
    }

    /**在线视频详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function docInfo($id)
    {
        $Model = new Video();
        return $Model->docInfo($id);
    }

    /**添加或修改在线视频
     * @param $params
     * @return array
     */
    public function updateDoc($params){
        $Model = new Video();
        $result = $Model->updateDoc($params);
        if($result){

            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置在线视频状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Video::where('ID',$params['id'])->value('status');
        $Model = new Video();
        if($status==1){
            $result = $Model->forbid($params['id']);
        }else{
            $result = $Model->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }



    /**删除在线视频
     * @param $params
     * @return array
     */
    public function delDocTrue($params)
    {
        $Model = new Video();
        $result = $Model->delDocTrue($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除在线视频到回收站
     * @param $params
     * @return array
     */
    public function delDoc($params)
    {
        $Model = new Video();
        $result = $Model->delDoc($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**在线视频还原
     * @param $params
     * @return array
     */
    public function backDoc($params)
    {
        $Model = new Video();
        $result = $Model->backDoc($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }
}