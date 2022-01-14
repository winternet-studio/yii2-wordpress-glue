<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Components;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use winternet\yii2wordpress\Db\ActiveRecord;
use winternet\yii2wordpress\Behaviors\ArStoreModelClassName;

class Kernel implements BootstrapInterface
{
    public function bootstrap($app)
    {
    }
}
