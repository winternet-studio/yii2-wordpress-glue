<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Db;

use Yii;
use yii\helpers\ArrayHelper;
use winternet\yii2wordpress\Models\WpPost;
use winternet\yii2wordpress\Db\ActiveQuery;
use \get_called_class;
use \add_action;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function init()
    {
        add_action('wp_trash_post', function ($post_id) {
            $obj = self::find()->where(['pid' => $post_id])->one();
            if ($obj) {
                $obj->delete();
            }
        });
    }

    public function beforeSave($insert)
    {
        $this->modelClass = static::class;
        $this->title = $this->wpPost->post_title;

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
