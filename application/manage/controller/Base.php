<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 10:33
 */

namespace app\manage\controller;

use app\common\controller\Common;
use think\facade\Env;
use think\Image;

class Base extends Common
{

    public function initialize()
    {
         parent::initialize();
         $this->authUser();
    }

    /**
     * 权限验证
     */
    protected function authUser()
    {
        $aid_s=session('admin_auth')['uid'];
        //已登录，不需要验证的权限
        $not_check =[
            'Usertool/caches',
            'Usertool/clearCache',
            'Index/index',
            'Index/welcome',
        ];

        if(!in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $not_check) && $aid_s!=1){
            $auth = new Auth();
            if(!$auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,$aid_s)){
                return $this->sendData('没有权限',1);
            }
        }



    }
}