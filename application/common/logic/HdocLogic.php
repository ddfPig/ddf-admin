<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:54
 */

namespace app\common\logic;


use app\common\model\Article;
use app\manage\controller\Base;

class HdocLogic extends Base
{
    /**在线文档列表
     * @param $request
     * @return \think\Paginator
     */
    public function docList($request)
    {
        $Model = new Article();
        return $Model->docList($request);
    }

    /**回收站在线文档
     * @param $request
     * @return \think\Paginator
     */
    public function docListBack($request)
    {
        $Model = new Article();
        return $Model->docListBack($request);
    }

    /**在线文档详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function docInfo($id)
    {
        $Model = new Article();
        return $Model->docInfo($id);
    }

    /**添加或修改在线文档
     * @param $params
     * @return array
     */
    public function updateDoc($params){
        $Model = new Article();
        $result = $Model->updateDoc($params);
        if($result){

            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置在线文档状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Article::where('ID',$params['id'])->value('status');
        $Model = new Article();
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



    /**删除在线文档
     * @param $params
     * @return array
     */
    public function delDocTrue($params)
    {
        $Model = new Article();
        $result = $Model->delDocTrue($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除在线文档到回收站
     * @param $params
     * @return array
     */
    public function delDoc($params)
    {
        $Model = new Article();
        $result = $Model->delDoc($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**在线文档还原
     * @param $params
     * @return array
     */
    public function backDoc($params)
    {
        $Model = new Article();
        $result = $Model->backDoc($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }
}