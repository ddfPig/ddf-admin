<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 14:19
 */

namespace app\common\validate;


use think\Validate;

class MenuValidate extends Validate
{
    protected $rule =   [
        'name'     => 'require|unique:menu',
        'sort'     => 'integer',
        'status'   => 'integer',
    ];

    protected $message  =   [
        'name.require'     => '分类名称必须填写',
        'name.unique'      => '分类名称已经存在',
        'sort.integer'     => '排序字段为整数',
        'status.integer'   => '状态字段为整数',
    ];

    protected $scene = [
        'add' => [
            'name',
            'sort',
            'status',
        ],
        'edit' => [
            'name',
            'sort',
            'status',
        ],
    ];

}