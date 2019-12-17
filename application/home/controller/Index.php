<?php
namespace app\home\controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch(':index',['data'=>'欢迎来到医诊通官网!目前正在紧张建设中...']);
    }
}
