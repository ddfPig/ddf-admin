<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-23
 * Time: 19:07
 */

namespace app\common\validate;


use think\Validate;

class AdvertValidate extends Validate
{
    protected $rule = [
        'tname'      =>'require|length:4,20',
        'sort'       =>'integer',
        //广告
        'adtitle'    => 'require|max:120',
        'adtypeID'   =>'require',
        'sort'       =>'integer',
        'status'     =>'integer',
        'mark'       =>'max:300',
        'adurl'      =>'url',
    ];

    protected $message = [
        'tname.require'       => '广告位名称必须填写',
        'sort.integer'        => '排序字段请输入整数',

        'adtitle.require'     => '广告名称必须填写',
        'adtitle.max'         => '广告名称长度最大120',
        'adtypeID.require'    => '请选择广告位',
        'sort.integer'        => '排序字段为整数',
        'status.integer'      => '状态字段为整数',
        'mark.max'            => '内容字符最大数为300',
        'adurl.url'           =>'请输入可访问的url地址'
    ];

    protected $scene = [
        'addt'=>[
             'tname',
             'sort',
        ],

        'add' => [
            'adtitle',
            'adtypeID',
            'sort',
            'status',
            'mark',
            'adurl'
        ],
        'edit' => [
            'adtitle',
            'adtypeID',
            'sort',
            'status',
            'mark',
            'adurl'
        ],
        'status'=>['status'],
    ];
}