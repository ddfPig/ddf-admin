<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 18:49
 */

namespace app\manage\controller;


use app\common\logic\PictureLogic;
use app\common\validate\PictureValidate;
use think\Request;

class Picture extends Base
{
    /**  图片素材列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $logic = new PictureLogic();
        $list = $logic->picList($request);
        $this->assign('category', get_tree(1));
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        return $this->fetch();
    }

    /**添加图片素材
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function addPic(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //数据验证
            $validate = new PictureValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //添加图片素材
            $logic = new PictureLogic();
            return $logic->updatePic($params);

        }else{
            $this->assign('category', get_tree(1));
            $this->assign('pic', []);
            return $this->fetch('updatepic');
        }

    }

    /**修改图片素材
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function updatePic(Request $request)
    {
        $logic = new PictureLogic();
        $id = $request->param('id');
        if($request->isPost()){
            $params = $request->post();
            //数据验证
            $validate = new PictureValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //修改图片素材

            return $logic->updatePic($params);

        }else{
            $info=$logic->picInfo($id);
            $this->assign('pic',json_decode($info['imgs'],true));
            $this->assign('info',$info);
            $this->assign('category', get_tree(1));
            return $this->fetch('updatepic');
        }
    }

    /** 图片素材状态
     * @param Request $request
     * @return array
     */
    public function setStatus(Request $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $logic = new PictureLogic();
            return $logic->setStatus($params);
        }
    }

    /**删除图片素材
     * @return array
     */
    public function delPic()
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $logic = new PictureLogic();
        return $logic->delPic($idArray);
    }
}