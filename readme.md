Yii2-Wordpress-Glue
===================

development of Wordpress-Plugins with yii2-framework

## Quick-Start

create a new Wordpress-Plugin by creation of a new Folder in `wp-content/plugins/awesome-plugin` and run/execute these tasks inner the awesome-plugin folder (replace awesome-plugin with your Plugin-Name!):

- create a new `composer.json`-File and require `HenryVolkmer/yii2-wordpress-glue`
- run `composer install`
- create the wordpress plugin-bootstrap file `awesome-plugin.php`:

```php
<?php
// wp-content/plugins/awesome-plugin/awesome-plugin.php

use HenryVolkmer\Yii2Wordpress\Kernel;

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
                    'basePath' => dirname(__DIR__) . '/messages'
                ]
            ]
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

In order to create a db-table, use the Yii2-Db-Migtation as follows:

```php
<?php

use yii\db\Migration;
use HenryVolkmer\Yii2Wordpress\Helpers;

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
