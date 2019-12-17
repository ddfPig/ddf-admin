<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 10:36
 */

namespace app\manage\controller;


use app\common\logic\SpecialLogic;
use app\common\validate\SpecialValidate;
use think\Request;

class Special extends Base
{
    /**  专题列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $logic = new SpecialLogic();
        $list = $logic->specList($request);
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        return $this->fetch();
    }

    /**添加专题
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function addSpec(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //数据验证
            $validate = new SpecialValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //添加专题
            $logic = new SpecialLogic();
            return $logic->updateSpec($params);

        }else{
            return $this->fetch('updateSpec');
        }

    }

    /**修改专题
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function updateSpec(Request $request)
    {
        $logic = new SpecialLogic();
        $id = $request->param('id');
        if($request->isPost()){
            $params = $request->post();
            //数据验证
            $validate = new SpecialValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //修改专题

            return $logic->updateSpec($params);

        }else{
            $info=$logic->specInfo($id);
            $this->assign('info',$info);
            return $this->fetch('updateSpec');
        }
    }

    /** 专题状态
     * @param Request $request
     * @return array
     */
    public function setStatus(Request $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $logic = new SpecialLogic();
            return $logic->setStatus($params);
        }
    }


    /**删除专题
     * @return array
     */
    public function delSpecTrue()
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $logic = new SpecialLogic();
        return $logic->delSpecTrue($idArray);
    }
}