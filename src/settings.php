<?php

return [
    'settings' => [
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'ru',
            'username' => 'root',
            'password' => 'toool',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'ru-Src',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/Src.log',
        ],
    ]
];
