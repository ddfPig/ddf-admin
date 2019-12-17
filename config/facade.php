<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-25
 * Time: 21:26
 */

return [
    'facade' => [
        \app\common\facade\SC::class =>\sc\SC::class,
        \app\common\facade\OnlyLogin::class=>\app\common\provider\OnlyLogin::class

    ],
    'alias' => [
        'SC' => \app\common\facade\SC::class,
        'OnlyLogin'=>\app\common\facade\OnlyLogin::class,
    ]
];
