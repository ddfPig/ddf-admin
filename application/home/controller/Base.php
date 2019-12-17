<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-08-03
 * Time: 14:10
 */

namespace app\home\controller;


use app\common\model\Templated;
use think\Controller;
use think\facade\Env;

class Base extends Controller
{
   protected function initialize()
   {
       $this->setView();
   }

    /**
     * 设置系统主题
     */
    protected function setView()
    {
        if(isMobile()){
            $theme = Templated::where('status','=',1)
                                ->where('type','=',2)->value('tname');
        }else{
            $theme = Templated::where('status','=',1)
                               ->where('type','=',1)->value('tname');
        }
        $theme= $theme?$theme:'default';
        $path = Env::get('root_path').'/template/'.$theme.'/';
        $this->view=$this->view->config('view_path',$path);
        $this->assign('theme_path',$path);
    }
}