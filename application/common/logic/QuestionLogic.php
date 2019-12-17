<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 19:04
 */

namespace app\common\logic;


use app\common\model\Question;
use app\manage\controller\Base;

class QuestionLogic extends Base
{
    /**常见问题列表
     * @param $request
     * @return \think\Paginator
     */
    public function questionList($request)
    {
        $Model = new Question();
        return $Model->questionList($request);
    }

    /**常见问题详情
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function questionInfo($id)
    {
        $Model = new Question();
        return $Model->questionInfo($id);
    }

    /**添加或修改常见问题
     * @param $params
     * @return array
     */
    public function updateQuestion($params){
        $Model = new Question();
        $result = $Model->updateQuestion($params);
        if($result){

            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置常见问题状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Question::where('ID',$params['id'])->value('status');
        $Model = new Question();
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



    /**删除常见问题
     * @param $params
     * @return array
     */
    public function delQuestion($params)
    {
        $Model = new Question();
        $result = $Model->delQuestion($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}