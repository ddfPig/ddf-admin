<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-29
 * Time: 10:22
 */
use think\facade\Env;
use Yurun\Util\Chinese;
use Yurun\Util\Chinese\Pinyin;
class Tool{
    //文件锁
    private static $_lockFp = array();
    /**锁文件 不同的模块设置不同锁文件  原则是：小模块可以共用一个文件  访问量大的模块单独设置锁文件
     * @param $lockFileName   路径
     * @return bool
     */
    public static function startLocker($lockFileName)
    {
        self::$_lockFp[$lockFileName] = $fp = fopen(Env::get('root_path') . '/data/lock/'.$lockFileName, 'r');
        if(!$fp)
            return FALSE;
        $try = 20;   //尝试20次
        $lock = false;
        do
        {
            $lock = flock($fp, LOCK_EX);
            if(!$lock)
                usleep(30000);  // 0.03秒
        }while(!$lock && --$try > 0);
        return $lock;
    }

    /**锁文件解锁
     * @param $lockFileName
     */
    public static function endLockers($lockFileName)
    {
        if(isset(self::$_lockFp[$lockFileName]))
        {
            @flock(self::$_lockFp[$lockFileName], LOCK_UN);
            @fclose(self::$_lockFp[$lockFileName]);
        }
    }

    /**获取中文字符串首字母
     * @param $data
     * @return string
     */
    public static function getFirst($data)
    {
        $info = Chinese::toPinyin($data, Pinyin::CONVERT_MODE_PINYIN_FIRST);
        return join($info['pinyinFirst'][0]);
    }


















}