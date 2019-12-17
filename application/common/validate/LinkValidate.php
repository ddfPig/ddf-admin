<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 9:25
 */

namespace app\common\validate;


use think\Validate;

class LinkValidate extends Validate
{
    protected $rule = [
        'linkname'      =>'require|max:10',
        'link'          =>'require|url',
        'sort'          =>'integer',
        'status'        =>'integer',
        'mark'          =>'max:500',

    ];

    protected $message = [
        'linkname.require'    => '链接名称必须填写',
        'linkname.max'        => '链接名称最大长10',
        'link.require'        => '链接地址必须填写',
        'link.url'            => '请输入可访问的url地址',
        'sort.integer'        => '排序字段为整数',
        'status.integer'      => '状态字段为整数',
        'mark.max'            => '内容字符最大数为500',

    ];

    protected $scene = [
        'add' => [
            'linkname',
            'link',
            'sort',
            'status',
            'mark',
        ],
        'edit' => [
            'linkname',
            'link',
            'sort',
            'status',
            'mark',
        ],
        'status'=>['status'],
    ];
}