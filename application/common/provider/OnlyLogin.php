<?php
/**
 * Created by PhpStorm.
 * User: 刘进义
 * Contact: ddf-128@163.com
 * Wechat:dd283681008
 * Date: 2019/8/4 20:54
 */
namespace app\common\provider;
use Cache,Cookie,SC,Log;
class OnlyLogin
{
    /**
     * 这是校验用户是否唯一登入的方法
     */
    public function onlyCheck()
    {
        // 客户端
        $cookieToken = Cookie::get('TOKEN'.SC::getUserInfo('uid'));
        // 服务端
        $cacheToken = Cache::get('TOKEN'.SC::getUserInfo('uid'));
        // 进行服务端的token与客户端token进行校验
        // 第一次登入$CacheToken 没有，异地登入的时候$cookieToken
        if (empty($cacheToken) || empty($cookieToken)) {
            Log::write('正常登入时候，异地登入时候');
            return true;
        }
        // 如果都有
        // 判断是否异地登入 如果相等那么就没有异地登入 所以当前是不会被T
        if ($cookieToken != $cacheToken) {
            Log::write('在异地登入了，本地就被T了');
            return false;
        }
        Log::write('常规操作');
        return true;
    }
    /**
     * 会根据用户的id作为key 生成对应标识
     */
    public function onlyRecord($user_id )
    {
        $token = $this->createToken($user_id);
        // 过期时间
        // 客户端
        Cookie::set('TOKEN'.$user_id, $token);
        // 服务端
        Cache::set('TOKEN'.$user_id, $token);
    }
    /**
     * 创建token的方法
     * 因为每一个项目token生成的规则不一样 唯一安全
     * 参考微信公众号生成token的方式
     */
    private function createToken($user_id)
    {
        $time  = time(); // 时间戳
        $nonce = mt_rand(10, 1000);
        $array = array($time, $nonce, 'ONLY_USER_TOKEN', $user_id);
        sort($array);
        $token = implode($array);
        return sha1($token);
    }
    /**
     * 清空用户的登入信息
     * @return [type] [description]
     */
    public function clear()
    {
    }
}