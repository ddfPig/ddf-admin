<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 15:06
 */

namespace app\common\validate;


use think\Validate;

class NewsValidate extends Validate
{
    protected $rule =   [
        'news_title'     => 'require',
        'news_columnid'  => 'require',
        'news_content'   => 'require',
        'listorder'      => 'integer',
        'news_zaddress'  => 'url',
    ];

    protected $message  =   [
        'news_title.require'     => '标题必须填写',
        'news_columnid.require'  => '请选择所属分类',
        'news_content.require'   => '内容必须填写',
        'listorder.integer'      => '排序字段为整数',
        'news_zaddress.url'      => '请输入有效的链接地址',
    ];

    protected $scene = [
        'add' => [
            'news_title',
            'news_columnid',
            'news_content',
            'listorder',
            'news_zaddress',
        ],
        'edit' => [
            'news_title',
            'news_columnid',
            'news_content',
            'listorder',
            'news_zaddress'
        ],
    ];

}