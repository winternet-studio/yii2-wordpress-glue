<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Components;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use HenryVolkmer\Yii2Wordpress\Db\ActiveRecord;
use HenryVolkmer\Yii2Wordpress\Behaviors\ArStoreModelClassName;

class Kernel implements BootstrapInterface
{
    public function bootstrap($app)
    {
    }
}
