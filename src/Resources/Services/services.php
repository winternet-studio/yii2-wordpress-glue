<?php
use winternet\yii2wordpress\helpers\StringHelper;

$wpPluginFolderName = basename(dirname(__FILE__, 5));

$assetDir = dirname(__DIR__, 7) . '/yii2wp_assets';
if (!is_dir($assetDir)) {
    mkdir($assetDir);
}

return [
    'id' => 'yii2wp-app',
    'aliases' => [
        '@Yii2Wordpress' => dirname(__DIR__, 2),
        '@app' => dirname(__DIR__, 6),
        '@assetCache' => $assetDir,
        '@log' => dirname(__DIR__, 8),
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__, 6),
    'params' => [
        'bsVersion' => 4,
        'wpPluginFolderName' => $wpPluginFolderName,
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@app/migrations',
                '@Yii2Wordpress/migrations',
            ],
            'migrationTable' => 'migrations_' . StringHelper::standardize($wpPluginFolderName),
        ],
    ],
    'bootstrap' => ['log','kernel'],
    'components' => [
        'view' => [
            'class' => 'winternet\yii2wordpress\components\View',
        ],
        'assetManager' => [
            'basePath' => '@assetCache',
            'baseUrl' => '/wp-content/plugins/yii2wp_assets',
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => [],
                ],
            ],
        ],
        'modelRegistry' => [
            'class' => 'winternet\yii2wordpress\components\ModelRegistry',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'username' => DB_USER,
            'password' => DB_PASSWORD,
            'charset'  => DB_CHARSET,
            'dsn' => 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            'tablePrefix' => $GLOBALS['table_prefix'],
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
            'class' => 'winternet\yii2wordpress\components\Kernel',
        ],
    ],
];
