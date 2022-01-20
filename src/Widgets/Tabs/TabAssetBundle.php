<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\widgets\tabs;

use yii\web\AssetBundle;
use winternet\yii2wordpress\interfaces\AssetBundleInterface;

class TabAssetBundle extends AssetBundle implements AssetBundleInterface {

	public $sourcePath = '@vendor/winternet-studio/yii2-wordpress-glue/src/widgets/tabs/assets';
	public $js = ['tabs.js'];
	public $css = ['tabs.css'];

	public function getJsDeps(): array {
		return ['jquery','jquery-ui-tooltip','jquery-ui-tabs'];
	}

}
