<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress\Widgets\Tabs;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use HenryVolkmer\Yii2Wordpress\Interfaces\TabAwareInterface;

/**
 * Displays Tabs in Backend for your Module.
 * Each Tab contains a Pjax-Container with a ActiveForm,
 * the FormFields are rendered via Model::formFields() Method.
 *
 * @todo Assets missing!
 */
class Tabs extends Widget
{
    public function init()
    {
        parent::init();

        global $post;

        Yii::$app->modelRegistry
            // Process only current post type
            ->filterPostType($post->post_type)
            // populate models
            ->findByPostId($post->ID)
            // validate again to show invalid data: persist cyclce has redirected.
            ->validate()
        ;
    }

    protected function getIsNewRecord(): bool
    {
        global $pagenow;

        return ($pagenow == 'post-new.php');
    }

    public function run()
    {
        $out = Html::beginTag('div', [
            'id' => 'yii2wp_settings_tabs_wrapper',
        ]);

        $out .= Html::beginTag('ul', [
            'id' => 'yii2wp_settings_tabs',
        ]);

        foreach (Yii::$app->modelRegistry->get() as $model) {
            $out .= $this->renderTabListItem($model);
        }

        $out .= Html::endTag('ul');

        foreach (Yii::$app->modelRegistry->get() as $model) {
            $out .= $this->renderTabContent($model);
        }

        $out .= Html::endTag('div');

        echo $out;
    }

    protected function renderTabListItem(TabAwareInterface $model): string
    {
        $out = Html::beginTag('li');

        $href = '#' . crc32(get_class($model)) . '-tab';
        $out .= Html::a(
            '<span>'. $model->getTabLabel() .'</span>',
            $href,
            ['id' => 'tab-' . $model->formName()]
        );
        $out .= Html::endTag('li');

        return $out;
    }

    protected function renderTabContent(TabAwareInterface $model): string
    {
        $cssId = crc32(get_class($model)) . '-tab';

        $out = Html::beginTag('div', [
            'id' => $cssId,
            'class' => 'yii2wp-tab'
        ]);

        // add css class for Input-errors
        $attributes = $model->formFields();

        if ($model->hasErrors()) {
            foreach ($attributes as $key => $attribute) {
                if (
                    !isset($attribute['attribute'])
                    || !$model->hasErrors($attribute['attribute'])) {
                    continue;
                }

                $options = ArrayHelper::getValue($attributes, $key . '.options', []);
                Html::addCssClass($options, ['ui-state-error','ui-corner-all']);
                ArrayHelper::setValue($attributes, $key . '.options', $options);
            }
        }

        $out .= DetailView::widget([
            'formClass' => ActiveForm::class,
            'model' => $model,
            'attributes' => $attributes,
            'mode' => DetailView::MODE_EDIT,
            'bootstrap' => false,
            'mainTemplate' => '{detail}',
            'hAlign' => 'left',
            'options' => ['style' => 'width:100%']
        ]);

        $out .= Html::endTag('div');

        return $out;
    }
}
