<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 13:21
 */

namespace app\common\model;


use think\Model;

class Options extends Model
{
     public function optionList($id)
     {
         return  Options::where(['group'=>$id,'display'=>1])->field('ID,name,title,extra,value,remark,type')
                          ->order('sort')->select();
     }
}