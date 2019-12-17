<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-23
 * Time: 19:06
 */

namespace app\manage\controller;


use app\common\logic\AdsLogic;
use app\common\model\Adtype;
use app\common\validate\AdminValidate;
use app\common\validate\AdvertValidate;
use think\Request;

class Advert extends Base
{
    /**广告列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $adsLogic = new AdsLogic();
        $list = $adsLogic->adsList($request);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**添加广告
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     * @throws \think\exception\DbException
     */
    public function newAdvert(Request $request)
    {
        if($request->isPost()){
            $params = $request->param();
            $params['ID'] = $this->uuid();
            //验证数据
            $validate = new AdvertValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            $adsLogic = new AdsLogic();
            return $adsLogic->updateAdvert($params);

        }else{
            $cate = new Adtype();
            $cates = $cate->tcate();
            $this->assign('cate',$cates);
            return $this->fetch('updateAdvert');
        }

    }

    /**修改广告
     * @param Request $request
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function updateAdvert(Request $request)
    {
         $adsLogic = new AdsLogic();
         $id = $request->param('id');
         if($request->isPost()){
             $params = $request->post();
             //验证数据
             $validate = new AdvertValidate();
             if(!$validate->scene('edit')->check($params)){
                 $error = $validate->getError();
                 return $this->sendData($error,0);
             }
             return $adsLogic->updateAdvert($params);
         }else{
             $cate = new Adtype();
             $cates = $cate->tcate();
             $info = $adsLogic->gginfo($id);
             $this->assign('cate',$cates);
             $this->assign('info',$info);
             return $this->fetch('updateAdvert');
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
            $adsLogic = new AdsLogic();
            return $adsLogic->setStatus($params);
        }
    }

    /**删除广告
     * @param Request $request
     * @return array
     */
    public function delAdvert(Request $request)
    {
        $idArray = array_unique((array)$request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除逻辑
        $adsLogic = new AdsLogic();
        return $adsLogic->delAdvert($idArray);
    }

    /************广告位**************************************************************/
    /**广告位列表
     * @param Request $request
     * @return mixed
     */
    public function tindex(Request $request)
    {
        $adsLogic = new AdsLogic();
        $list = $adsLogic->tlist($request);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**添加广告位
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function addType(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //验证数据
            $validate = new AdvertValidate();
            if(!$validate->scene('addt')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            $adsLogic = new AdsLogic();
            return $adsLogic->addType($params);
        }else{
            return $this->fetch('addType');
        }

    }

    /**修改广告位
     * @param Request $request
     * @return array|mixed
     */
    public function updateType(Request $request)
    {
        $params = $request->post();
        $id = $request->param('id','00000000-0000-0000-0000-000000000000');
        $adsLogic = new AdsLogic();
        if($request->isPost()){
            //验证数据
            $validate = new AdvertValidate();
            if(!$validate->scene('addt')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }
            return $adsLogic->addType($params);
        }else{
            $info=$adsLogic->adsInfo($id);
            $this->assign('info',$info);
            return $this->fetch('addType');
        }

    }

    /**删除广告位
     * @param Request $request
     * @return array
     */
    public function delType(Request $request)
    {
        $idArray = array_unique((array)$request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        //删除逻辑
        $adsLogic = new AdsLogic();
        return $adsLogic->delType($idArray);
    }




}