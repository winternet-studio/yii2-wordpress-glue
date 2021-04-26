<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Db;

use HenryVolkmer\Yii2Wordpress\Models\WpPost;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        $this->modelClass = static::class;

        return parent::beforeSave($insert);
    }

    public static function find()
    {
        $finder = parent::find();
        $finder->where(['modelClass' => static::class]);

        return $finder;
    }

    public function getWpPost()
    {
        return $this->hasOne(WpPost::class, [
            'ID' => 'pid'
        ]);
    }
}
