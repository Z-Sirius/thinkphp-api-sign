<?php

return [
    'status' => env('app.sign', true), // 是否开启验证
    'apps'   => [
        [
            'app_id'     => '',
            'app_secret' => '',
            'timestamp'  => 5 * 60, // 默认5分钟
            'status'     => 1, // 是否禁用
        ],
    ],
];