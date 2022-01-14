<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Widgets\Tabs;

/**
 * Wordpress render its own <form>-Tags.
 * We want ActiveForm without Form-Tags here.
 *
 * {@inheritdoc}
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    public function run()
    {
        if (!empty($this->_fields)) {
            throw new \InvalidCallException('Each beginField() should have a matching endField() call.');
        }

        return \ob_get_clean();
    }
}
