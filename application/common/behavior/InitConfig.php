<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 14:06
 */

namespace app\common\behavior;

use Config,Cache;
class InitConfig
{
    public function run()
    {
        try {
            $config =   Cache::get('config_data');
            if(!$config){
                $config =  config_lists();
                Cache::set('config_data',$config);
            }
            Config::set($config,'web');
        }catch(Exception $e){}
    }
}