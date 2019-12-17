<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 14:02
 */

namespace app\manage\controller;


use app\common\logic\LoginLogic;
use app\common\validate\AdminValidate;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Validate;
use think\Request;

class Signin extends Controller
{
    /**登录页面
     * @return mixed
     */
     public function index()
     {
         return $this->fetch();
     }

    /**登录验证
     * @param Request $request
     */
     public function login(Request $request)
     {
         $params = $request->post();
         $validate = new AdminValidate();
         if(!$validate->scene('login')->check($params)){
             $error = $validate->getError();
             return ['code'=>0,'message'=>$error,'data'=>[]];
         }

         //验证码
         if(!captcha_check($params['code'],1)){
             return ['code'=>0,'message'=>'验证码错误','data'=>[]];
         };

         //验证逻辑
         $login = new LoginLogic();
         return $login->login($params);

     }

     //验证码
     public function captcha(){
         $captcha = new Captcha();
         return $captcha->entry(1);
     }

    /**
     * 退出登录
     */
     public function signinOut()
     {
         if(is_login('admin')){
             $login = new LoginLogic();
             $login->loginOut();
             session('[destroy]');
             $this->redirect('manage/signin/index');
         } else {
             $this->redirect('manage/signin/index');
         }
     }

}