<?php
/**
 * Created by PhpStorm.
 * User: 刘进义
 * Contact: ddf-128@163.com
 * Wechat:dd283681008
 * Date: 2019/8/4 20:55
 */
namespace sc;
use Session;
class SC
{
    /**
     * 用户登录的session key
     */
    CONST LOGIN_MARK_SESSION_KEY = 'LOGIN_MARK_SESSION';
    /**
     * 权限信息
     * @var string
     */
    CONST USER_ROLE_SESSION = 'USER_ROLE_SESSION';
    /**
     * USER用户信息
     * @var string
     */
    CONST USER_INFO_SESSION = 'USER_INFO_SESSION';

    CONST USER_IS_SYSTEM_SESSION = 'USER_IS_SYSTEM_SESSION';
    // /**
    //  * 是否设置用户登入的有效时间
    //  * @var string
    //  */
    // CONST CHECK_TIME_SESSION = 'CHECK_TIME_SESSION';
    //
    // private $checkTime = false;

    //---------------------------设置和判断用户的是否登入
    // 设置用户登入token
    public function setLogin($value)
    {
        Session::set(self::LOGIN_MARK_SESSION_KEY, $value);
    }
    // 判断用户是否登入成功
    public function getLogin()
    {
        return Session::get(self::LOGIN_MARK_SESSION_KEY);
    }
    // 判断用户是否为系统管理员
    public function setIsSystem($value)
    {
        Session::set(self::USER_IS_SYSTEM_SESSION, $value);
    }
    // 判断用户是否登入成功
    public function getIsSystem()
    {
        return Session::get(self::USER_IS_SYSTEM_SESSION);
    }
    //---------------------------设置用户和获取用户的登入信息
    // 设置用户的信息
    public function setUserInfo($value)
    {
        Session::set(self::USER_INFO_SESSION, $value);
    }
    // 获取用户的信息
    // [
    // 'uid'       => $user->uid,
    // 'user_name' => $user->user_name,
    // 'is_system' => $user->is_system,
    // 'nick_name' => $user->nick_name,
    //...
    // 'role_id'   => $user->role_id
    // ]
    public function getUserInfo($value = null)
    {

        $userInfo = Session::get(self::USER_INFO_SESSION);
        return ($value) ? $userInfo[$value] : $userInfo;
    }
    //--------------------------设置和获取用户的权限
    // 设置用户的信息
    public function setUserRole($value)
    {
        Session::set(self::USER_ROLE_SESSION, $value);
    }
    // 获取用户的信息
    public function getUserRole()
    {
        return Session::get(self::USER_ROLE_SESSION);
    }
    //-------------------------用户退出清空用户缓存信息
    // 退出登入
    public function clear()
    {
        Session::del(self::USER_INFO_SESSION);
        Session::del(self::USER_ROLE_SESSION);
        Session::del(self::LOGIN_MARK_SESSION_KEY);
    }
}