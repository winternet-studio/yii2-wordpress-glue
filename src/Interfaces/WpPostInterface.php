<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Interfaces;

use yii\db\ActiveRecordInterface;

interface WpPostInterface extends ActiveRecordInterface
{
    /**
     * the Posttype this AR belongs to
     */
    public static function getWpType(): string;
}
