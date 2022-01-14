<?php

use yii\db\Migration;
use winternet\yii2wordpress\Helpers\MigrationHelper;
use winternet\yii2wordpress\Models\Template;

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
