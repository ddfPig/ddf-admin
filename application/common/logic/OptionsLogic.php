<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 13:22
 */

namespace app\common\logic;


use app\common\model\Options;
use app\manage\controller\Base;

class OptionsLogic extends Base
{
    public function optionList($id)
    {
         $model = new Options();
         return $model->optionList($id);
    }
}