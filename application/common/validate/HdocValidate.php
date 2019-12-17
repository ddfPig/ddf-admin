<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:53
 */

namespace app\common\validate;


use think\Validate;

class HdocValidate extends Validate
{
    protected $rule =   [
        'title'      => 'require',
        'cateID'     => 'require',
        'content'    => 'require',
        'sort'       => 'integer',
        'status'     =>'integer',
    ];

    protected $message  =   [
        'title.require'   => '标题必须填写',
        'cateID.require'  => '请选择所属分类',
        'content.require' => '内容必须填写',
        'sort.integer'    => '排序字段为整数',
        'status.integer'  => '状态排序字段为整数',
    ];

    protected $scene = [
        'add' => [
            'title',
            'cateID',
            'content',
            'sort',
            'status'
        ],
        'edit' => [
            'title',
            'cateID',
            'content',
            'sort',
            'status'
        ],
    ];
}