<?php

if (!isset($_ENV['WP_PLUGIN_FOLDERNAME'])) {
    throw new \Exception('The $_ENV["WP_PLUGIN_FOLDERNAME"] is not set!');
}

return [
    'id' => 'yii2wp-app',
    'aliases' => [
        '@app' => dirname(__DIR__, 5),
        '@log' => dirname(__DIR__, 7),
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'params' => [
        'bsVersion' => 4
    ],
    'components' => [
        'view' => [
            'class' => 'HenryVolkmer\Yii2Wordpress\Components\View',
        ],
        'assetManager' => [
            'basePath' => '@app/assets',
            'baseUrl' => '@web/wp-content/plugins/' . $_ENV['WP_PLUGIN_FOLDERNAME'] . '/app/assets',
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => []
                ]
            ]
        ],
        'modelRegistry' => [
            'class' => 'HenryVolkmer\Yii2Wordpress\Components\ModelRegistry',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'username' => DB_USER,
            'password' => DB_PASSWORD,
            'charset'  => DB_CHARSET,
            'dsn' => 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            'tablePrefix' => $GLOBALS['table_prefix']
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error','warning','trace'],
                    'logFile' => '@log/debug.log',
                    'logVars' => [],
                ],
            ],
        ],
    ]
];
