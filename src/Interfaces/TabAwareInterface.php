<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Interfaces;

use yii\db\ActiveRecordInterface;

interface TabAwareInterface extends ActiveRecordInterface
{
    /**
     * Label to Display in Wordpress-Module-Settings-Tab
     * e.g: return Yii::t('my-wp-module','Common Settings');
     */
    public function getTabLabel(): string;

    /**
     * Form fields to render.
     * This array is passed to the `attributes`-Property of the DetailView-Widget
     * if you dont know how to specify this, have a look at:
     *
     * - https://www.yiiframework.com/doc/api/2.0/yii-widgets-detailview
     * - https://github.com/kartik-v/yii2-detail-view
     */
    public function formFields(): array;
}
