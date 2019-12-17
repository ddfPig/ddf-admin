<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-31
 * Time: 9:09
 */

namespace app\common\logic;


use app\common\model\Picture;
use app\manage\controller\Base;

class PictureLogic extends Base
{
    /**图片素材列表
     * @param $request
     * @return \think\Paginator
     */
    public function picList($request)
    {
        $Model = new Picture();
        return $Model->picList($request);
    }


    /**图片素材详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function picInfo($id)
    {
        $Model = new Picture();
        return $Model->picInfo($id);
    }

    /**添加或修改图片素材
     * @param $params
     * @return array
     */
    public function updatePic($params){
        $Model = new Picture();
        $result = $Model->updatePic($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置图片素材状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Picture::where('ID',$params['id'])->value('status');
        $Model = new Picture();
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



    /**删除图片素材
     * @param $params
     * @return array
     */
    public function delPic($params)
    {
        $Model = new Picture();
        $result = $Model->delPic($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}