<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Components;

use \wp_enqueue_script;
use \wp_enqueue_style;

/**
 * registers Yii2-Assets to wordpress via wp_enqueue_script and wp_enqueue_style
 */
class View extends \yii\web\View
{
    public function registerAssetsToWp()
    {
        foreach (array_keys($this->assetBundles) as $bundle) {
            $this->registerAssetFilesToWp($bundle);
        }
    }

    protected function registerAssetFilesToWp($name)
    {
        if (!isset($this->assetBundles[$name])) {
            return;
        }
        $bundle = $this->assetBundles[$name];
        if ($bundle) {
            foreach ($bundle->depends as $dep) {
                $this->registerAssetFilesToWp($dep);
            }
           
            foreach ($bundle->js as $script) {
                wp_enqueue_script($name, $bundle->baseUrl . '/' . $script, [], false, true);
            }

            foreach ($bundle->css as $style) {
                wp_enqueue_style($style, $bundle->baseUrl . '/' . $style);
            }
        }
        unset($this->assetBundles[$name]);
    }
}
