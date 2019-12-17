<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-31
 * Time: 9:07
 */

namespace app\common\validate;



use think\Validate;

class PictureValidate extends Validate
{
    protected $rule =   [
        'ptitle'       => 'require',
        'pic'          => 'require',
        'status'       => 'integer',
        'sort'         => 'integer',
        'link'         => 'url'
    ];

    protected $message  =   [
        'ptitle.require'    => '发布名称必须填写',
        'pic.require'       => '请上传图片素材',
        'sort.integer'      => '排序字段为整数',
        'status.integer'    => '状态字段为整数',
        'link.url'          => '请输入有效的链接地址',
    ];

    protected $scene = [
        'add' => [
            'ptitle',
            'pic',
            'status',
            'sort',
            'link',
        ],
        'edit' => [
            'ptitle',
            'pic',
            'status',
            'sort',
            'link'
        ],
    ];
}