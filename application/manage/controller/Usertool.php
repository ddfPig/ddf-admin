<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-08-01
 * Time: 9:24
 */

namespace app\manage\controller;


use think\Request;
use think\facade\Cache;
use think\facade\Env;

class Usertool extends Base
{
    /**清除缓存页面
     * @return mixed
     */
    public function caches()
    {
        return $this->fetch();
    }

    /**清空缓存操作
     * @param Request $request
     */
    public function clearCache(Request $request)
    {
        $data=$request->post();
        if(!empty($data['cache'])){
            foreach ($data['cache'] as $key => $value) {
                if($value){
                    Cache::rm($key);
                }
            }
        }

        if(!empty($data['temp'])){
            $temp_path = Env::get('runtime_path').'temp'.DIRECTORY_SEPARATOR;
            if(is_dir($temp_path)){
                del_dir_file($temp_path,true);
            }
        }
        if(!empty($data['html'])){
            $html_path = Env::get('runtime_path').'html'.DIRECTORY_SEPARATOR;
            if(is_dir($html_path)){
                del_dir_file($html_path,true);
            }
        }
        return $this->sendData('清除缓存成功！',1);
    }

}