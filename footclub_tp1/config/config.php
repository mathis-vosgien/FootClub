<?php
// config/config.php
return [
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '8889',
        'name' => getenv('DB_NAME') ?: 'footclub',
        'user' => getenv('DB_USER') ?: 'root',
        'pass' => getenv('DB_PASS') ?: 'root',
        'charset' => 'utf8mb4'
    ],
    'app' => [
        'base_url' => getenv('APP_BASE_URL') ?: '/',
        'upload_dir' => __DIR__ . '/../public/uploads'
    ]
];
