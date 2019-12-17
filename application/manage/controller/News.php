<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 15:05
 */

namespace app\manage\controller;


use app\common\logic\NewsLogic;
use app\common\validate\NewsValidate;
use think\Request;

class News extends Base
{
    /**  文章列表
     * @param Request $request
     * @return mixed
     */
     public function index(Request $request)
     {
         $news = new NewsLogic();
         $list = $news->newsList($request);
         $this->assign('category', get_tree(1));
         $this->assign('list',$list);
         $this->assign('keywords',$request->param('keywords'));
         return $this->fetch();
     }

    /**添加文章
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
     public function addNews(Request $request)
     {
         if($request->isPost()){
             $params = $request->post();
             $params['ID'] = $this->uuid();
              //数据验证
             $validate = new NewsValidate();
             if(!$validate->scene('add')->check($params)){
                 $error = $validate->getError();
                 return $this->sendData($error,0);
             }

             //添加新闻
             $newLogic = new NewsLogic();
             return $newLogic->updateNews($params);

         }else{
             $this->assign('category', get_tree(1));
             return $this->fetch('updateNews');
         }

     }

    /**修改文章
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
     public function updateNews(Request $request)
     {
         $newLogic = new NewsLogic();
         $id = $request->param('id');
         if($request->isPost()){
             $params = $request->post();
             //数据验证
             $validate = new NewsValidate();
             if(!$validate->scene('edit')->check($params)){
                 $error = $validate->getError();
                 return $this->sendData($error,0);
             }

             //修改新闻

             return $newLogic->updateNews($params);

         }else{
             $info=$newLogic->newsInfo($id);
             $this->assign('info',$info);
             $this->assign('category', get_tree(1));
             return $this->fetch('updateNews');
         }
     }

    /** 文章状态
     * @param Request $request
     * @return array
     */
     public function setStatus(Request $request)
     {
         if($request->isGet()){
             $params = $request->param();
             //修改状态逻辑
             $newLogic = new NewsLogic();
             return $newLogic->setStatus($params);
         }
     }

    /**删除文章到回收站
     * @param Request $request
     * @return array
     */
     public function delNews(Request $request)
     {
         $idArray = array_unique((array)$this->request->param('id'));
         if (empty($idArray) ) {
             return $this->sendData('请选择要操作的数据',0);
         }
         //删除管理人员逻辑
         $newLogic = new NewsLogic();
         return $newLogic->delNews($idArray);
     }

    /**回收站文章
     * @param Request $request
     * @return mixed
     */
     public function back(Request $request)
     {
         $news = new NewsLogic();
         $list = $news->newsListBack($request);
         $this->assign('category', get_tree(1));
         $this->assign('list',$list);
         $this->assign('keywords',$request->param('keywords'));
         return $this->fetch('back');
     }

    /**文章还原
     * @param Request $request
     * @return array
     */
    public function backNews(Request $request)
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除管理人员逻辑
        $newLogic = new NewsLogic();
        return $newLogic->backNews($idArray);
    }

    /**删除文章
     * @return array
     */
    public function delNewsTrue()
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除管理人员逻辑
        $newLogic = new NewsLogic();
        return $newLogic->delNewsTrue($idArray);
    }
}