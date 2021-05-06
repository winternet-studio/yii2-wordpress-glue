<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Db;

use Yii;
use yii\helpers\ArrayHelper;
use HenryVolkmer\Yii2Wordpress\Models\WpPost;
use HenryVolkmer\Yii2Wordpress\Db\ActiveQuery;
use \get_called_class;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        $this->modelClass = static::class;

        return parent::beforeSave($insert);
    }

    public static function instantiate($row)
    {
        $class = ArrayHelper::getValue($row, 'modelClass', static::class);
        return new $class;
    }

    public static function find()
    {
        $class = Yii::createObject(get_called_class());
        $finder = parent::find();

        if ($class->hasAttribute('modelClass')) {
            $finder->where(['modelClass' => static::class]);
        }

        return $finder;
    }

    public function getWpPost()
    {
        return $this->hasOne(WpPost::class, [
            'ID' => 'pid'
        ]);
    }
}
