<?php

return [
    'id' => 'storage',
    'basePath' => dirname(__DIR__),
    'components' => [
        'urlManager' => require(__DIR__.'/urlManager.php'),
        'request' => [
            'baseUrl' => '/storage/web',
        ],
    ],
];
