<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Interfaces;

use yii\db\ActiveRecordInterface;

interface WpPostInterface extends ActiveRecordInterface
{
    /**
     * the Posttype this AR belongs to
     */
    public static function getWpType(): string;
}
