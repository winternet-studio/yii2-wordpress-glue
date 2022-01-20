Yii2-Wordpress-Glue
===================

Development of Wordpress plugins with Yii2 framework

## Quick Start

Create a new Wordpress plugin by creating a new folder in eg. `wp-content/plugins/awesome-plugin` and run/execute these tasks that that folder:

- create `composer.json` with at least this:

```json
{
	"repositories": [
		{
			"type": "composer",
			"url": "https://asset-packagist.org"
		}
	]
}
```

- run `composer require winternet-studio/yii2-wordpress-glue`
- create the wordpress plugin bootstrap file eg. `awesome-plugin.php` (replace `myplugin` with name of your plugin):

```php
<?php
// wp-content/plugins/awesome-plugin/awesome-plugin.php

use winternet\yii2wordpress\KernelRunner;

require_once(__DIR__ .'/vendor/autoload.php');

$config = [
	'aliases' => [
		'@myplugin' => __DIR__,  //this will become your namespace, eg. myplugin\models\MyModel
	],
	'language' => 'en-US',
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

$isDebug = true;  //set true during development
$kernel = new KernelRunner($config, null, $isDebug);
$kernel->run();
```

## Translations

look at the $config-array in the example above:
The `i18n`-Component is configured with basePath "plugin/messages".
Refer to the [Yii2-Documentation](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n) for more informations.


## Migrations

- create a folder "migrations" in your Application (wp-content/plugins/awesome-plugin/migrations)
- on the cli: `vendor/bin/yii2wp migrate/create 'MyMigrationName'`

A new file should be generated in your migrations folder:

```php
<?php
class m191119_103515_createTables extends \yii\db\Migration {
	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable(
			'{{%mymodule_mytable}}',
			array_merge(\winternet\yii2wordpress\helpers\MigrationHelper::getSystemCols(), [
				'foo' => $this->text(),
				'bar' => $this->string(10)
			])
		);
	}
}
```

#### Core Migration

`vendor/bin/yii2wp migrate/create --migrationPath=@Yii2Wordpress/migrations 'AddTemplates'`

## Credits

This is originally a fork of [Henry Volkmer's project](https://github.com/HenryVolkmer/yii2-wordpress-glue) but many changes have been changed.
