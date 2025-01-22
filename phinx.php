<?php

$config = require __DIR__ . '/config.php';

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => 'development',
            'production' => [
                'adapter' => 'mysql',
                'host' => $config['database']['host'],
                'name' => $config['database']['dbname'],
                'user' => $config['db_user'],
                'pass' => $config['db_pass'],
                'port' => $config['database']['port'],
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host' => $config['database']['host'],
                'name' => $config['database']['dbname'],
                'user' => $config['db_user'],
                'pass' => $config['db_pass'],
                'port' => $config['database']['port'],
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => $config['database']['host'],
                'name' => $config['database']['dbname'],
                'user' => $config['db_user'],
                'pass' => $config['db_pass'],
                'port' => $config['database']['port'],
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation',
    ];
