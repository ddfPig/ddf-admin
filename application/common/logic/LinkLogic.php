<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 9:17
 */

namespace app\common\logic;


use app\common\model\Link;
use app\manage\controller\Base;

class LinkLogic extends Base
{
    /**链接列表
     * @param $request
     * @return \think\Paginator
     */
    public function linkList($request)
    {
        $linkModel = new Link();
        return $linkModel->linkList($request);
    }

    /**链接详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function linkInfo($id)
    {
        $linkModel = new Link();
        return $linkModel->linkInfo($id);
    }

    /**更新链接
     * @param $params
     * @return array
     */
    public function updateLink($params)
    {
        $linkModel = new Link();
        $result = $linkModel->updateLink($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Link::where('ID',$params['id'])->value('status');
        $linkModel = new Link();
        if($status==1){
            $result = $linkModel->forbid($params['id']);
        }else{
            $result = $linkModel->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /** 删除链接
     * @param $params
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delLink($params)
    {
        $linkModel = new Link();
        $result = $linkModel->delLink($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}