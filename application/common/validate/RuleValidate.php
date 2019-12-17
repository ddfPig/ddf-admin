<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 16:28
 */

namespace app\common\validate;


use think\Validate;

class RuleValidate extends Validate
{
    protected $rule =   [
        'num'     => 'require|unique:auth_rule',
        'link'    => 'require',
        'title'   => 'require|chs|max:50',
        'sort'    => 'integer',
        'status'  => 'integer',
        'ischeck' => 'integer',
    ];

    protected $message  =   [
        'num.require'     => '权限编号必须填写',
        'num.unique'      => '权限编号已经存在',
        'link.require'    => '权限路径必须填写',
        'title.require'   => '权限名称必须填写',
        'title.chs'       => '权限名称必须是汉字',
        'title.max'       => '权限名称最大长度50',
        'sort.integer'    => '排序字段为整数',
        'status.integer'  => '状态字段为整数',
        'ischeck.integer' => '监测字段为整数',
    ];

    protected $scene = [
        'add' => [
             'num',
             'link',
             'title',
             'sort',
             'status',
             'ischeck'
        ],
        'edit' => [
            'link',
            'title',
            'sort',
            'status',
            'ischeck'
        ],
    ];



}