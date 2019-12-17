<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-08-03
 * Time: 14:41
 */

namespace app\common\validate;


use think\Validate;

class TemplatedValidate extends Validate
{
    protected $rule =   [
        'imgs'        => 'require',
        'tname'       => 'require',
        'title'       => 'require',
        'open'        => 'integer',
        'status'      => 'integer',
        'link'        => 'url',
    ];

    protected $message  =   [
        'imgs.require'       => '请上传封面图片',
        'tname.require'      => '主题目录必须填写',
        'title.require'      => '主题名称必须填写',
        'sort.integer'       => '排序字段为整数',
        'open.integer'       => '启用字段为整数',
        'link.url'           => '请输入有效的链接地址',
    ];

    protected $scene = [
        'add' => [
            'imgs',
            'tname',
            'title',
            'open',
            'status',
            'link'
        ],
        'edit' => [
            'imgs',
            'tname',
            'title',
            'open',
            'status',
            'link',
        ],
    ];
}