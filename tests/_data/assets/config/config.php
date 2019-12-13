<?php

return [
    'cardoe'     => [
        'baseuri' => '/cardoe/',
    ],
    'models'      => [
        'metadata' => 'memory',
    ],
    'database'    => [
        'adapter'  => 'mysql',
        'host'     => 'localhost',
        'username' => 'user',
        'password' => 'passwd',
        'name'     => 'demo',
    ],
    'test'        => [
        'parent' => [
            'property'  => 1,
            'property2' => 'yeah',
        ],
    ],
    'issue-12725' => [
        'channel' => [
            'handlers' => [
                0 => [
                    'name'           => 'stream',
                    'level'          => 'debug',
                    'fingersCrossed' => 'info',
                    'filename'       => 'channel.log',
                ],
                1 => [
                    'name'           => 'redis',
                    'level'          => 'debug',
                    'fingersCrossed' => 'info',
                ],
            ],
        ],
    ],
];