<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 10:31
 */

namespace app\manage\controller;

class Index extends Base
{
    public function index()
    {
//        for($i=1;$i<46;$i++){
//            echo $this->uuid()."<br/>";
//        }
//        exit;
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }
}