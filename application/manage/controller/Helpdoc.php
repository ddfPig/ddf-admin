<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:15
 */

namespace app\manage\controller;


use app\common\logic\HdocLogic;
use app\common\validate\HdocValidate;
use think\Request;

class Helpdoc extends Base
{
    /**  在线文档列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $logic = new HdocLogic();
        $list = $logic->docList($request);
        $this->assign('category', get_tree2(1));
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        return $this->fetch();
    }

    /**添加在线文档
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function addDoc(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //数据验证
            $validate = new HdocValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //添加在线文档
            $logic = new HdocLogic();
            return $logic->updateDoc($params);

        }else{
            $this->assign('category', get_tree2(1));
            return $this->fetch('updateDoc');
        }

    }

    /**修改在线文档
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function updateDoc(Request $request)
    {
        $logic = new HdocLogic();
        $id = $request->param('id');
        if($request->isPost()){
            $params = $request->post();
            //数据验证
            $validate = new HdocValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //修改在线文档

            return $logic->updateDoc($params);

        }else{
            $info=$logic->docInfo($id);
            $this->assign('info',$info);
            $this->assign('category', get_tree2(1));
            return $this->fetch('updateDoc');
        }
    }

    /** 在线文档状态
     * @param Request $request
     * @return array
     */
    public function setStatus(Request $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $logic = new HdocLogic();
            return $logic->setStatus($params);
        }
    }

    /**删除在线文档到回收站
     * @param Request $request
     * @return array
     */
    public function delDoc(Request $request)
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除在线文档到回收站
        $logic = new HdocLogic();
        return $logic->delDoc($idArray);
    }

    /**回收站在线文档
     * @param Request $request
     * @return mixed
     */
    public function back(Request $request)
    {
        $logic = new HdocLogic();
        $list = $logic->docListBack($request);
        $this->assign('category', get_tree2(1));
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        return $this->fetch('back');
    }

    /**在线文档还原
     * @param Request $request
     * @return array
     */
    public function backDoc(Request $request)
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $logic = new HdocLogic();
        return $logic->backDoc($idArray);
    }

    /**删除在线文档
     * @return array
     */
    public function delDocTrue()
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $logic = new HdocLogic();
        return $logic->delDocTrue($idArray);
    }
}