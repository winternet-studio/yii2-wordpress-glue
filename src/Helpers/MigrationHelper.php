<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\helpers;

/*
 * ```php
 * $this->createTable('myTable',ArrayHelper::merge(MigrationHelper::getSystemCols(),['foo' => 'text']));
 * ```
 */
class MigrationHelper extends \yii\db\Migration
{
    public $syscols;

    public static function getSystemCols()
    {
        $self = new static;
        $self->syscols = [
            'id'			=> $self->primaryKey(),
            'pid'			=> $self->integer(),
            'updated_by'	=> $self->integer(),
            'created_by'	=> $self->integer(),
            'created_at'	=> $self->timestamp(6),
            'updated_at'	=> $self->timestamp(6),
            'modelClass'	=> $self->text(),
            'type'			=> $self->string(25)->notNull()->defaultValue('default'),
            'state'			=> $self->string(250),
            'title'			=> $self->string(250),
        ];

        return $self->syscols;
    }
}
