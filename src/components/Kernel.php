<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use winternet\yii2wordpress\db\ActiveRecord;
use winternet\yii2wordpress\behaviors\ArStoreModelClassName;

class Kernel implements BootstrapInterface {

	public function bootstrap($app) {
	}

}
