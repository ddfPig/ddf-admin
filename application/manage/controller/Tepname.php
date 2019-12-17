<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-08-03
 * Time: 14:40
 */

namespace app\manage\controller;


use app\common\logic\TemplatedLogic;
use app\common\validate\TemplatedValidate;
use think\facade\Env;
use think\Request;

class Tepname extends Base
{
    /**  主题管理列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $logic = new TemplatedLogic();
        $list = $logic->templateList($request);
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        return $this->fetch();
    }

    /**添加主题管理
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function addTemplate(Request $request)
    {
        if($request->isPost()){
            $params = $request->post();
            $params['ID'] = $this->uuid();
            //数据验证
            $validate = new TemplatedValidate();
            if(!$validate->scene('add')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //验证主题目录是否存在
            $theme = $params['tname'];
            $path = Env::get('root_path').'/template/'.$theme.'/';
            if(!is_dir($path))
            {
                return $this->sendData("目录".$theme."不存在",0);
            }


            //添加主题管理
            $logic = new TemplatedLogic();
            return $logic->updateTemplate($params);

        }else{
            return $this->fetch('updateTemplate');
        }

    }

    /**模板启用
     * @param Request $request
     * @return array
     */
    public function setOn(Request  $request)
    {
        if($request->isGet()){
            $params = $request->param();
            //修改状态逻辑
            $logic = new TemplatedLogic();
            return $logic->setOn($params);
        }
    }

    /**修改主题管理
     * @param Request $request
     * @return array|mixed
     * @throws \Exception
     */
    public function updateTemplate(Request $request)
    {
        $logic = new TemplatedLogic();
        $id = $request->param('id');
        if($request->isPost()){
            $params = $request->post();
            //数据验证
            $validate = new TemplatedValidate();
            if(!$validate->scene('edit')->check($params)){
                $error = $validate->getError();
                return $this->sendData($error,0);
            }

            //验证主题目录是否存在
            $theme = $params['tname'];
            $path = Env::get('root_path').'/template/'.$theme.'/';
            if(!is_dir($path))
            {
                return $this->sendData("目录".$theme."不存在",0);
            }

            //修改主题管理
            return $logic->updateTemplate($params);

        }else{
            $info=$logic->templateInfo($id);
            $this->assign('info',$info);
            return $this->fetch('updateTemplate');
        }
    }

    /**删除主题模板
     * @return array
     */
    public function delTemplate()
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $logic = new TemplatedLogic();
        return $logic->delTemplate($idArray);
    }
}