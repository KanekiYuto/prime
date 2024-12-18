<?php

return [
    'slow-requests' => [
        'name' => '低效请求',
    ],

    'usage' => [
        'name' => [
            'requests' => 'Top 10 用户请求',
            'slow_requests' => 'Top 10 请求缓慢的用户',
            'jobs' => 'Top 10 用户调度作业',
            'default' => '应用程序使用',
        ],
    ],

    'slow-queries' => [
        'name' => '低效查询',
    ],

    'slow-outgoing-requests' => [
        'name' => '请求超时',
    ],

    'slow-jobs' => [
        'name' => '低效调度作业',
    ],

    'servers' => [
        'memory' => '内存',
        'cpu' => 'CPU',
        'storage' => '磁盘',
    ],

    'queues' => [
        'name' => '队列',
        'actions' => [
            'queued' => '队列中',
            'processing' => '处理中',
            'processed' => '已处理',
            'released' => '已完成',
            'failed' => '失败',
        ],
    ],

    'period-selector' => [
        '1h' => '1小时',
        '6h' => '6小时',
        '24h' => '24小时',
        '7d' => '7天',
    ],

    'exceptions' => [
        'name' => '异常',
    ],

    'cache' => [
        'name' => '缓存',
    ],

    'no-results' => '无结果',

    'theme' => [
        'dark' => '暗色',
        'light' => '亮色',
        'system' => '跟随',
    ],
];
