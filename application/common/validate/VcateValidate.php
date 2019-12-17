<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 18:07
 */

namespace app\common\validate;


use think\Validate;

class VcateValidate extends Validate
{
    protected $rule =   [
        'cname'     => 'require|unique:video_chapter',
        'sort'      => 'integer',
        'status'    => 'integer',
    ];

    protected $message  =   [
        'cname.require'     => '分类名称必须填写',
        'cname.unique'      => '分类名称已经存在',
        'sort.integer'      => '排序字段为整数',
        'status.integer'    => '状态字段为整数',
    ];

    protected $scene = [
        'add' => [
            'cname',
            'sort',
            'status',
        ],
        'edit' => [
            'cname',
            'sort',
            'status',
        ],
    ];
}