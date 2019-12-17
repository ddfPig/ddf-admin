<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 13:21
 */

namespace app\manage\controller;


use app\common\logic\OptionsLogic;
use app\common\model\Oplog;
use app\common\model\Options;
use app\common\model\Picfiles;
use think\facade\Cache;
use think\Request;

class Sysoptions extends Base
{
    /** 网站基本配置
     * @param Request $request
     * @return mixed
     */
     public function index(Request $request)
     {
         $id = $request->param('id',1);
         $logic = new OptionsLogic();
         $list = $logic->optionList($id);
         if($list) {
             $this->assign('list',$list);
         }
         $this->assign('id',$id);
         return $this->fetch();
     }

    /**保存网站基本配置
     * @param Request $request
     * @return array
     */
     public function updateOptions(Request $request)
     {
         $config = $request->param('config/a');
         $picID = $request->param('picID');
         $oldPic = Options::where('name','logo')->value('value');
         if($config && is_array($config)){

             foreach ($config as $name => $value) {
                 $map = ['name' => $name];
                 if(is_array($value)){
                     $value=implode(",", $value);
                 }
                 Options::where($map)->setField('value', $value);
             }
             //处理logo,存在图片ID即已经上传新的图片
             if($picID){
                 $maps[] = ['ID','eq',$picID];
                 Picfiles::where($maps)->setField('state',1);
                 //原有图片注释为未使用

                 Picfiles::where('strPath',md5($oldPic))->setField('state',0);
             }
         }
         Cache::rm('config_data');
         return $this->sendData('操作成功',1);
     }
}