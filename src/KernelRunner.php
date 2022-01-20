<?php

declare(strict_types=1);

namespace winternet\yii2wordpress;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use \add_action;
use \get_post;
use \WP_Post;
use \register_activation_hook;
use \register_uninstall_hook;

require_once dirname(__FILE__, 4) . '/yiisoft/yii2/Yii.php';

class KernelRunner
{
    private $debug;
    private $appConf = [];

    public function __construct(array $appConf=[], string $wpPluginFile=null, bool $isDebug=false)
    {
        $this->debug = $isDebug;

        /**
         * The Path to the origin Plugin
         * Origin Plugin is the Plugin which make useage of
         * Yii2Wordpress.
         */
        Yii::setAlias('@plugin', dirname(__FILE__, 5));
        Yii::setAlias('@pluginBootstrapFile', $wpPluginFile);

        $this->appConf = ArrayHelper::merge(
            require dirname(__FILE__, 2) . '/src/resources/services/services.php',
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
         * Installation
         */
        register_activation_hook(Yii::getAlias('@pluginBootstrapFile'), function () {
            $webApp = Yii::$app;
            new \yii\console\Application($this->appConf);
            $res = Yii::$app->runAction('migrate/up', ['interactive' => false]);
            Yii::$app = $webApp;
        });

        /**
         * Exception: Serialization of 'Closure' is not allowed
         *
        register_uninstall_hook(Yii::getAlias('@plugin'), function () {
            $webApp = Yii::$app;
            new \yii\console\Application($this->appConf);
            Yii::$app->runAction('migrate/down', ['all' => 'all','interactive' => false]);
            Yii::$app = $webApp;
        });
        */

        /**
         * add Tab-Navigation to backend => wp_post-edit
         */
        add_action('edit_form_after_title', function (WP_Post $post) {
            if (!Yii::$app->modelRegistry->hasPosttype($post->post_type)) {
                return;
            }
            echo widgets\tabs\Tabs::widget();
        });

        /**
         * if a Wordpress-Post was Saved, the $_POST-Data are here
         * available.
         */
        add_action('save_post', function (int $post_id) {
            $post = get_post($post_id);

            Yii::$app->modelRegistry
                // only process models attached to post_type
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
