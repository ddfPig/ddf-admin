<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-08-03
 * Time: 14:42
 */

namespace app\common\logic;


use app\common\model\Templated;
use app\manage\controller\Base;

class TemplatedLogic extends Base
{
    /**主题管理列表
     * @param $request
     * @return \think\Paginator
     */
    public function templateList($request)
    {
        $Model = new Templated();
        return $Model->templateList($request);
    }


    /**主题管理详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function templateInfo($id)
    {
        $Model = new Templated();
        return $Model->templateInfo($id);
    }

    /**添加或修改主题管理
     * @param $params
     * @return array
     */
    public function updateTemplate($params){
        $Model = new Templated();
        $result = $Model->updateTemplate($params);
        if($result){

            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**启用模板主题
     * @param $params
     * @return array
     */
    public function setOn($params)
    {
        $Model = new Templated();
        $result = $Model->setOn($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除模板主题
     * @param $params
     * @return array
     */
    public function delTemplate($params)
    {
        $Model = new Templated();
        $result = $Model->delTemplate($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }
}