<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Widgets\Tabs;

use yii\web\AssetBundle;
use winternet\yii2wordpress\Interfaces\AssetBundleInterface;

class TabAssetBundle extends AssetBundle implements AssetBundleInterface
{
    public $sourcePath = '@vendor/winternet-studio/yii2-wordpress-glue/src/Widgets/Tabs/assets';
    public $js = ['tabs.js'];
    public $css = ['tabs.css'];

    public function getJsDeps(): array
    {
        return ['jquery','jquery-ui-tooltip','jquery-ui-tabs'];
    }
}
