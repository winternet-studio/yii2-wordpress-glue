<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Widgets\Tabs;

use yii\web\AssetBundle;
use HenryVolkmer\Yii2Wordpress\Interfaces\AssetBundleInterface;

class TabAssetBundle extends AssetBundle implements AssetBundleInterface
{
    public $sourcePath = '@vendor/henryvolkmer/yii2-wordpress-glue/src/Widgets/Tabs/assets';
    public $js = ['tabs.js'];
    public $css = ['tabs.css'];

    public function getJsDeps(): array
    {
        return ['jquery','jquery-ui-tooltip','jquery-ui-tabs'];
    }
}
