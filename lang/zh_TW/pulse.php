<?php

return [
    'slow-requests' => [
        'name' => '低效請求',
    ],

    'usage' => [
        'name' => [
            'requests' => 'Top 10 用戶請求',
            'slow_requests' => 'Top 10 請求緩慢的用戶',
            'jobs' => 'Top 10 用戶調度作業',
            'default' => '應用程式使用',
        ],
    ],

    'slow-queries' => [
        'name' => '低效查詢',
    ],

    'slow-outgoing-requests' => [
        'name' => '請求超時',
    ],

    'slow-jobs' => [
        'name' => '低效調度作業',
    ],

    'servers' => [
        'memory' => '记忆体',
        'cpu' => 'CPU',
        'storage' => '硬碟',
    ],

    'queues' => [
        'name' => '伫列',
        'actions' => [
            'queued' => '伫列中',
            'processing' => '處理中',
            'processed' => '已處理',
            'released' => '已完成',
            'failed' => '失敗',
        ],
    ],

    'period-selector' => [
        '1h' => '1小時',
        '6h' => '6小時',
        '24h' => '24小時',
        '7d' => '7天',
    ],

    'exceptions' => [
        'name' => '例外',
    ],

    'cache' => [
        'name' => '快取',
    ],

    'no-results' => '無結果',

    'cad-header' => [
        'details' => [
            'threshold' => '阈值 :threshold 毫秒，',
            'past' => '过去:period',
        ],
    ],

    'period' => [
        '6_hours' => '6小時',
        '24_hours' => '24小時',
        '7_days' => '7天',
        'default' => '1小時',
    ],

    'theme' => [
        'dark' => '暗色',
        'light' => '亮色',
        'system' => '跟隨',
    ],
];
