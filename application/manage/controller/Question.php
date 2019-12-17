<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 19:02
 */

namespace app\manage\controller;


use app\common\logic\QuestionLogic;
use app\common\validate\QuestionValidate;
use think\Request;

class Question extends Base
{
    /**  常见问题列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $logic = new QuestionLogic();
        $list = $logic->questionList($request);
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        return $this->fetch();
    }

    /**添加常见问题
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function addQuestion(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //数据验证
            $validate = new QuestionValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //添加常见问题
            $logic = new QuestionLogic();
            return $logic->updateQuestion($params);

        }else{
            return $this->fetch('updateQuestion');
        }

    }

    /**修改常见问题
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function updateQuestion(Request $request)
    {
        $logic = new QuestionLogic();
        $id = $request->param('id');
        if($request->isPost()){
            $params = $request->post();
            //数据验证
            $validate = new QuestionValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //修改常见问题

            return $logic->updateQuestion($params);

        }else{
            $info=$logic->questionInfo($id);
            $this->assign('info',$info);
            return $this->fetch('updateQuestion');
        }
    }

    /** 常见问题状态
     * @param Request $request
     * @return array
     */
    public function setStatus(Request $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $logic = new QuestionLogic();
            return $logic->setStatus($params);
        }
    }


    /**删除常见问题
     * @return array
     */
    public function delQuestion()
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $logic = new QuestionLogic();
        return $logic->delQuestion($idArray);
    }

}