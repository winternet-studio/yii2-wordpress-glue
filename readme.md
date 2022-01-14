Yii2-Wordpress-Glue
===================

Development of Wordpress plugins with Yii2 framework

## Quick Start

Create a new Wordpress plugin by creating a new folder in eg. `wp-content/plugins/awesome-plugin` and run/execute these tasks that that folder:

- create `composer.json` with at least this (could not get it working without these settings):

```php
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://asset-packagist.org"
        }
    ],
    "minimum-stability": "dev"
}
```

- run `composer require winternet-studio/yii2-wordpress-glue "^1.0"`
- create the wordpress plugin bootstrap file eg. `awesome-plugin.php`:

```php
<?php
// wp-content/plugins/awesome-plugin/awesome-plugin.php

use winternet\yii2wordpress\Kernel;

require_once __DIR__ . '/vendor/autoload.php';

$config = [
    'language' => 'de',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'defaultDuration' => 600,
        ],
        'i18n' => [
            'translations' => [
                'myApp*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath' => dirname(__DIR__) . '/messages',
                ],
            ],
        ],
    ],
];

$isDebug = (isset($_ENV['DEBUG']) && $_ENV['DEBUG'] === true);
$kernel = new KernelRunner($config,$isDebug);
$kernel->run();
```

## Translations

look at the $config-array in the example above:
The `i18n`-Component is configured with basePath "plugin/messages".
Refer to the [Yii2-Documentation](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n) for more informations.


## Migrations

- create a Folter "Migrations" in your Application (wp-content/plugins/awesome-plugin/Migrations)
- on the cli: `vendor/bin/yii2wp migrate/create 'MyMigrationName'`

A new File should be generated in your Migrations Folder:

```php
<?php

use yii\db\Migration;
use winternet\yii2wordpress\Helpers;

class m191119_103515_createTables extends \yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable(
			'{{%mymodule_mytable}}',
			array_merge(MigrationHelper::getSystemCols(), [
				'foo' => $this->text(),
				'bar' => $this->string(10)
			])
		);
	}
}
```

#### Core Migration

`vendor/bin/yii2wp migrate/create --migrationPath=@Yii2Wordpress/Migrations 'AddTemplates'`

## Credits

This is a fork of [Henry Volkmer's project](https://github.com/HenryVolkmer/yii2-wordpress-glue).
