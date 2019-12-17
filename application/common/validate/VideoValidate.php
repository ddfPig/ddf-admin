<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 17:59
 */

namespace app\common\validate;


use think\Validate;

class VideoValidate extends  Validate
{
    protected $rule =   [
        'vititle'     => 'require',
        'chapterID'   => 'require',
        'link'        => 'require',
        'sort'        => 'integer',
        'status'      =>'integer',
    ];

    protected $message  =   [
        'vititle.require'    => '标题必须填写',
        'chapterID.require'  => '请选择所属分类',
        'link.require'       => '链接地址必须填写',
        'sort.integer'       => '排序字段为整数',
        'status.integer'     => '状态排序字段为整数',
    ];

    protected $scene = [
        'add' => [
            'vititle',
            'chapterID',
            //'link',
            'sort',
            'status'
        ],
        'edit' => [
            'vititle',
            'chapterID',
           // 'link',
            'sort',
            'status'
        ],
    ];
}