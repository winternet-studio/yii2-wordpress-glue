<?php

if (!isset($_ENV['WP_PLUGIN_FOLDERNAME'])) {
    throw new \Exception('The $_ENV["WP_PLUGIN_FOLDERNAME"] is not set!');
}

$assetDir = dirname(__DIR__, 7) . '/yii2wp_assets';
if (!is_dir($assetDir)) {
    mkdir($assetDir);
}

return [
    'id' => 'yii2wp-app',
    'aliases' => [
        '@app' => dirname(__DIR__, 6),
        '@assetCache' => $assetDir,
        '@log' => dirname(__DIR__, 8),
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__, 6),
    'params' => [
        'bsVersion' => 4
    ],
    'bootstrap' => ['log','kernel'],
    'components' => [
        'view' => [
            'class' => 'HenryVolkmer\Yii2Wordpress\Components\View',
        ],
        'assetManager' => [
            'basePath' => '@assetCache',
            'baseUrl' => '/wp-content/plugins/yii2wp_assets',
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
        // Application Kernel
        'kernel' => [
            'class' => 'HenryVolkmer\Yii2Wordpress\Components\Kernel'
        ]
    ]
];
