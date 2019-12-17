<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-23
 * Time: 19:07
 */

namespace app\common\logic;


use app\common\model\Ads;
use app\common\model\Adtype;
use app\manage\controller\Base;

class AdsLogic extends Base
{
    /**广告列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function adsList($request)
    {
        $adsModel = new Ads();
        return $adsModel->adsList($request);
    }

    /**广告详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function gginfo($id)
    {
        $adsModel = new Ads();
        return $adsModel->gginfo($id);
    }

    /**更新广告
     * @param $params
     * @return array
     * @throws \think\exception\PDOException
     */
    public function updateAdvert($params)
    {
        $adsModel = new Ads();
        $result = $adsModel->updateAdvert($params);
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
        $status = Ads::where('ID',$params['id'])->value('status');
        $adsModel = new Ads();
        if($status==1){
            $result = $adsModel->forbid($params['id']);
        }else{
            $result = $adsModel->resume($params['id']);
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
    public function delAdvert($params)
    {
        $adsModel = new Ads();
        $result = $adsModel->delAdvert($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }








    /************广告位**************************************************************/

    /**广告位列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function tList($request)
    {
        $adtype = new Adtype();
        return $adtype->tList($request);
    }

    /**单个广告位信息
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function adsInfo($id)
    {
        $adtype = new Adtype();
        return $adtype->adsInfo($id);
    }

    /**添加/修改广告位
     * @param $params
     * @return array
     */
    public function addType($params)
    {
        $adtype = new Adtype();
        $result = $adtype->addType($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除广告位
     * @param $params
     * @return array
     */
    public function delType($params)
    {
        $adtype = new Adtype();
        $result = $adtype->delType($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}