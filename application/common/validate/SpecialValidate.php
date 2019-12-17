<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 10:37
 */

namespace app\common\validate;


use think\Validate;

class SpecialValidate extends Validate
{
    protected $rule =   [
        'sptitle'     => 'require',
        'spinfo'      => 'require',
        'spcontent'   => 'require',
        'sort'        => 'integer',
        'status'      => 'integer',
    ];

    protected $message  =   [
        'sptitle.require'    => '标题必须填写',
        'spinfo.require'     => '请填写内容介绍',
        'spcontent.require'  => '请填写专题内容',
        'sort.integer'       => '排序字段为整数',
        'status.integer'     => '状态排序字段为整数',
    ];

    protected $scene = [
        'add' => [
            'sptitle',
            'spinfo',
            'spcontent',
            'sort',
            'status'
        ],
        'edit' => [
            'sptitle',
            'spinfo',
            'spcontent',
            'sort',
            'status'
        ],
    ];
}