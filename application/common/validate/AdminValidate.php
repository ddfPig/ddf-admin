<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 8:54
 */

namespace app\common\validate;


use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'username'   =>'require|alphaDash|length:4,20',
        'userpass'   => 'require|alphaNum|length:6,30',
        'email'      =>'email',
        'mobile'     =>'mobile',
        'status'     =>'integer',
        'mark'       =>'max:500',
        'gid'        =>'require'
    ];

    protected $message = [
        'username.require'    => '用户账号必须填写',
        'username.alphaDash'  => '用户账号必须是字母和数字及下划线',
        'username.length'     => '用户账号字符数在4到20之间',
        'userpass.require'    => '用户密码必须填写',
        'userpass.length'     => '用户密码长度必须在6-30个字符之间！',
        'userpass.alphaNum'   => '用户密码必须是字母和数字',
        'email.email'         => '请输入正确的邮箱地址',
        'mobile.mobile'       => '请输入正确的手机号码',
        'status.integer'      => '请输入整数',
        'mark.max'            => '内容字符最大数为500',
        'gid.require'         => '请选择角色'
    ];

    protected $scene = [
        'add' => [
             'username',
             'userpass',
             'email',
             'mobile',
             'status',
             'mark',
             'gid'
        ],
        'edit'  => [
            'username',
            'email',
            'mobile',
            'status',
            'mark',
            'gid'
        ],
        'pass'   =>['userpass'],
        'status' =>['status'],
        'login'  =>['username','userpass'],
    ];
}