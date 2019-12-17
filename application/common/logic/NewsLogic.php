<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 15:38
 */

namespace app\common\logic;


use app\common\model\News;
use app\manage\controller\Base;

class NewsLogic extends Base
{
    /**文章列表
     * @param $request
     * @return \think\Paginator
     */
    public function newsList($request)
    {
        $newsModel = new News();
        return $newsModel->newsList($request);
    }

    /**回收站文章
     * @param $request
     * @return \think\Paginator
     */
    public function newsListBack($request)
    {
        $newsModel = new News();
        return $newsModel->newsListBack($request);
    }

    /**文章详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function newsInfo($id)
    {
        $newsModel = new News();
        return $newsModel->newsInfo($id);
    }

    /**添加或修改文章
     * @param $params
     * @return array
     */
    public function updateNews($params){
        $newsModel = new News();
        $result = $newsModel->updateNews($params);
        if($result){

            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置文章状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = News::where('ID',$params['id'])->value('news_open');
        $newsModel = new News();
        if($status==1){
            $result = $newsModel->forbid($params['id']);
        }else{
            $result = $newsModel->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除文章到回收站
     * @param $params
     * @return array
     */
    public function delNews($params)
    {
        $newsModel = new News();
        $result = $newsModel->delNews($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除文章
     * @param $params
     * @return array
     */
    public function delNewsTrue($params)
    {
        $newsModel = new News();
        $result = $newsModel->delNewsTrue($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**文章还原
     * @param $params
     * @return array
     */
    public function backNews($params)
    {
        $newsModel = new News();
        $result = $newsModel->backNews($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }


}