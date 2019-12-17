<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 10:37
 */

namespace app\common\logic;


use app\common\model\Special;
use app\manage\controller\Base;

class SpecialLogic extends Base
{
    /**专题列表
     * @param $request
     * @return \think\Paginator
     */
    public function specList($request)
    {
        $Model = new Special();
        return $Model->specList($request);
    }

    /**专题详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function specInfo($id)
    {
        $Model = new Special();
        return $Model->specInfo($id);
    }

    /**添加或修改专题
     * @param $params
     * @return array
     */
    public function updateSpec($params){
        $Model = new Special();
        $result = $Model->updateSpec($params);
        if($result){

            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置专题状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Special::where('ID',$params['id'])->value('status');
        $Model = new Special();
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



    /**删除专题
     * @param $params
     * @return array
     */
    public function delSpecTrue($params)
    {
        $Model = new Special();
        $result = $Model->delSpecTrue($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}