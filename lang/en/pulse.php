<?php

return [
    'slow-requests' => [
        'name' => 'Slow Requests',
    ],

    'usage' => [
        'name' => [
            'requests' => 'Top 10 Users Making Requests',
            'slow_requests' => 'Top 10 Users Experiencing Slow Endpoints',
            'jobs' => 'Top 10 Users Dispatching Jobs',
            'default' => 'Application Usage',
        ],
    ],

    'slow-queries' => [
        'name' => 'Slow Queries',
    ],

    'slow-outgoing-requests' => [
        'name' => 'Slow Outgoing Requests',
    ],

    'slow-jobs' => [
        'name' => 'Slow Jobs',
    ],

    'servers' => [
        'memory' => 'Memory',
        'cpu' => 'CPU',
        'storage' => 'Storage',
    ],

    'queues' => [
        'name' => 'Queues',
        'actions' => [
            'queued' => 'Queued',
            'processing' => 'Processing',
            'processed' => 'Processed',
            'released' => 'Released',
            'failed' => 'Failed',
        ],
    ],

    'period-selector' => [
        '1h' => '1h',
        '6h' => '6h',
        '24h' => '24h',
        '7d' => '7d',
    ],

    'exceptions' => [
        'name' => 'Exceptions',
    ],

    'cache' => [
        'name' => 'Cache',
    ],

    'no-results' => 'No results',

    'theme' => [
        'dark' => 'Dark',
        'light' => 'Light',
        'system' => 'System',
    ],
];
