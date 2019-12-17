<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 13:06
 */

namespace app\common\validate;


use think\Validate;

class RoleValidate extends Validate
{
    protected $rule = [
        'gname'  => 'require|chs|length:4,20|unique:auth_group',
        'gcode'  => 'require|alpha',
        'status' => 'integer',
        'info'   => 'max:500'
    ];

    protected $message = [
        'gname.require'   => '角色名称必须填写',
        'gname.alpha'     => '角色名称必须是中文',
        'gname.length'    => '角色名称字符在4到20个之间',
        'gname.unique'    => '角色名称已经存在',
        'gcode.require'   => '角色缩写必须填写',
        'gcode.alpha'     => '角色缩写必须是英文字母',
        'status.integer'  => '状态必须是整数',
        'info.max'        => '内容介绍字符最大字符数为500'
    ];

    protected $scene = [
        'add' => [
              'gname',
              'gcode',
              'status',
              'info'
        ],
        'edit' => [
            'gname',
            'gcode',
            'status',
            'info'
        ],
    ];

}