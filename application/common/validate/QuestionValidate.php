<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 19:03
 */

namespace app\common\validate;


use think\Validate;

class QuestionValidate extends Validate
{
    protected $rule =   [
        'question'     => 'require',
        'answer'       => 'require',
        'status'       => 'integer',
        'sort'         => 'integer',
        'flag'         => 'integer',
    ];

    protected $message  =   [
        'question.require'    => '常见问题名称必须填写',
        'answer.require'      => '常见问题回答必须填写',
        'sort.integer'        => '排序字段为整数',
        'status.integer'      => '状态字段为整数',
        'flag.integer'        => '属性字段为整数',
    ];

    protected $scene = [
        'add' => [
            'question',
            'answer',
            'status',
            'sort',
            'flag'
        ],
        'edit' => [
            'question',
            'answer',
            'status',
            'sort',
            'flag'
        ],
    ];
}