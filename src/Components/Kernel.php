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
        Event::on(
            ActiveRecord::class,
            ActiveRecord::EVENT_INIT,
            function (Event $event) use ($app) {
                if (!$event->sender->hasAttribute('modelClass')) {
                    return;
                }
                /*
                $event->sender->attachBehavior(
                    ArStoreModelClassName::class,
                    ArStoreModelClassName::class
                );
                */
            }
        );
    }
}
