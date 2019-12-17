<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 9:16
 */

namespace app\manage\controller;



use app\common\logic\LinkLogic;
use app\common\validate\LinkValidate;
use think\Request;

class Link extends Base
{
    /**链接列表
     * @param Request $request
     * @return mixed
     */
   public function index(Request $request)
   {
       $linkLogic = new LinkLogic();
       $list = $linkLogic->linkList($request);
       $this->assign('list',$list);
       return $this->fetch();
   }

    /**添加链接
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
   public function newLink(Request $request)
   {
        if($request->isPost()){
            $params = $request->param();
            $params['ID'] = $this->uuid();
            //验证数据
            $validate = new LinkValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            $linkLogic = new LinkLogic();
            return $linkLogic->updateLink($params);
        }else{
            return $this->fetch('updateLink');
        }
   }

    /**更新链接
     * @param Request $request
     * @return array|mixed
     */
    public function updateLink(Request $request)
    {
        $linkLogic = new LinkLogic();
        $id = $request->param('id');
        if($request->isPost()){
            $params = $request->post();
            //验证数据
            $validate = new LinkValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }
            return $linkLogic->updateLink($params);
        }else{
            $info = $linkLogic->linkInfo($id);
            $this->assign('info',$info);
            return $this->fetch('updateLink');
        }
    }

    /**设置状态
     * @param Request $request
     * @return array
     */
    public function setStatus(Request $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $linkLogic = new LinkLogic();
            return $linkLogic->setStatus($params);
        }
    }

    /**删除链接
     * @param Request $request
     * @return array
     */
    public function delLink(Request $request)
    {
        $idArray = array_unique((array)$request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除逻辑
        $linkLogic = new LinkLogic();
        return $linkLogic->delLink($idArray);
    }


}