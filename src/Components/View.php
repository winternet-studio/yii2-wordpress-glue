<?php
declare(strict_types=1);

namespace winternet\yii2wordpress\components;

use Yii;
use winternet\yii2wordpress\interfaces\AssetBundleInterface;
use \wp_enqueue_script;
use \wp_enqueue_style;

/**
 * Registers Yii2 assets in WordPress via wp_enqueue_script and wp_enqueue_style
 */
class View extends \yii\web\View {

	public function registerAssetsToWp() {
		foreach (array_keys($this->assetBundles) as $bundle) {
			$this->registerAssetFilesToWp($bundle);
		}
	}

	protected function registerAssetFilesToWp($name) {
		if (!isset($this->assetBundles[$name])) {
			return;
		}
		$bundle = $this->assetBundles[$name];
		if ($bundle) {
			foreach ($bundle->depends as $dep) {
				$this->registerAssetFilesToWp($dep);
			}
		   
			foreach ($bundle->js as $script) {
				$jsDeps = ($bundle instanceof AssetBundleInterface ? $bundle->getJsDeps() : []);
				wp_enqueue_script($name, $bundle->baseUrl . '/' . $script, $jsDeps, false, true);
			}

			foreach ($bundle->css as $style) {
				wp_enqueue_style($style, $bundle->baseUrl . '/' . $style);
			}
		}
		unset($this->assetBundles[$name]);
	}

}
