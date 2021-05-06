<?php

declare(strict_types=1);

namespace HenryVolkmer\Yii2Wordpress;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use \add_action;
use \get_post;
use \WP_Post;

require_once dirname(__FILE__, 4) . '/yiisoft/yii2/Yii.php';

class KernelRunner
{
    private bool $debug;
    private $appConf = [];

    public function __construct(array $appConf=[], bool $isDebug=false)
    {
        $this->debug = $isDebug;

        /**
         * The Path to the origin Plugin
         * Origin Plugin is the Plugin which make useage of
         * Yii2Wordpress.
         */
        Yii::setAlias('@plugin', dirname(__FILE__, 5));

        /**
         * The origin Plugin Name
         */
        if (!isset($_ENV['WP_PLUGIN_FOLDERNAME'])) {
            $_ENV['WP_PLUGIN_FOLDERNAME'] = basename(dirname(__FILE__, 5));
        }

        $this->appConf = ArrayHelper::merge(
            require dirname(__FILE__, 2) . '/src/Resources/Services/services.php',
            $appConf
        );
    }

    public function getAppConfig(): array
    {
        return $this->appConf;
    }

    public function run()
    {
        new Application($this->appConf);

        if (!$this->debug) {
            Yii::$app->errorHandler->unregister();
        }

        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }

        /**
         * add Tab-Navigation to backend => wp_post-edit
         */
        add_action('edit_form_after_title', function (WP_Post $post) {
            if (!Yii::$app->modelRegistry->hasPosttype($post->post_type)) {
                return;
            }
            echo Widgets\Tabs\Tabs::widget();
        });

        /**
         * if a Wordpress-Post was Saved, the $_POST-Data are here
         * available.
         */
        add_action('save_post', function (int $post_id) {
            $post = get_post($post_id);

            Yii::$app->modelRegistry
                // only process Models attached to post_type
                ->filterPostType($post->post_type)
                // populate (find) data from Database
                ->findByPostId($post_id)
                // fallback for models without post-id (not found in DB)
                // so new instances get an post-id (attribute pid)
                ->setPostId($post_id)
                // populate attributes with new $_POST-Data
                ->load(Yii::$app->request->post())
                // persist without validation:
                // Instead show errors after redirection.
                ->persist(false)
            ;
        });
    }
}
