<?php

return [
    'default' => env('LOG_CHANNEL', 'daily'),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/lumen.log'),
            'level' => 'debug',
        ],

        'access' => [
            'driver' => 'single',
            'path' => storage_path('logs/access.log'),
            'level' => 'info',
        ],
    ],
];
