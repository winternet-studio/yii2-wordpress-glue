<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Models;

use yii\db\ActiveQuery;
use winternet\yii2wordpress\Db\ActiveRecord;

class WpPost extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%posts}}';
    }

    public function findPostPage(): ActiveQuery
    {
        $finder = static::find();
        $finder->andWhere([
            'post_type' => ['post','page'],
            'post_status' => ['draft','publish','inherit']
        ]);

        return $finder;
    }
}
