<?php

use yii\db\Migration;
use HenryVolkmer\Yii2Wordpress\Helpers\MigrationHelper;
use HenryVolkmer\Yii2Wordpress\Models\Template;

/**
 * Class m210506_102441_AddTemplates
 */
class m210506_102441_AddTemplates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            Template::tableName(),
            MigrationHelper::getSystemCols()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Template::tableName());
    }
}
