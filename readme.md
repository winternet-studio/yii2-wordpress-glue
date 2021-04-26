Yii2-Wordpress-Glue
===================

development of Wordpress-Plugins with yii2-framework

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
