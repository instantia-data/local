<?php

/**
 * Local publish
 */
return [
    'views' => [
        'folder' => 'local'
    ],
    'control' => [
        'folder'=>'Local'
    ],
    'tests' => 1,
    'routes' => [
        'file'=>'local'
    ],
    'replaces' => [
        'view' => [
            ['from' => 'local::', 'to' => 'local.'],
        ],
        'lang' => [
            ['from' => 'local::', 'to' => ''],
            ['from' => 'library::', 'to' => ''],
        ],
        'namespace'=> [
            ['from' => 'Local\\Http\\Controllers', 'to' => 'App\\Http\\Controllers\\Local'],
            ['from' => 'Local\\Tests', 'to' => 'Tests\\Feature'],
        ]
    ],
    'tags'=>[
        //'id-local-views',
        //'id-local-lang',
        'id-local-controller',
        //'id-local-route',
        'id-local-config',
        'id-local-tests',
        'id-local-css',
        'id-local-js'
    ]
];

