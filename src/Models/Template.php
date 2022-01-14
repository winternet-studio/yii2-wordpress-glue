<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Models;

use Yii;
use yii\db\ActiveQuery;
use kartik\detail\DetailView;
use winternet\yii2wordpress\Helpers\StringHelper;
use winternet\yii2wordpress\Db\ActiveRecord;
use winternet\yii2wordpress\Interfaces as Interfaces;
use \register_post_type;
use \is_dir;
use \mkdir;
use \stripslashes;
use \html_entity_decode;
use \file_put_contents;

class Template extends ActiveRecord implements Interfaces\WpPostInterface, Interfaces\TabAwareInterface
{
    public $templateContent;

    public function init()
    {
        if (!is_dir(Yii::getAlias('@plugin/Templates'))) {
            mkdir(Yii::getAlias('@plugin/Templates'));
        }

        return parent::init();
    }

    public static function registerBoilerplate(string $parentMenue)
    {
        Yii::$app->modelRegistry->add(new static());

        register_post_type(static::getWpType(), [
            'labels' => [
                'name' => 'Templates',
                'singular_name'  => 'template',
                'add_new_item' => 'Add new Template',
                'edit_item' => 'Edit Template',
                'new_item' => 'New Template',
                'view_item' => 'View Template',
                'search_items' => 'Search Templates',
                'not_found' => 'No templates found',
                'menu_name' => "Templates",
            ],
            'show_in_menu' => 'edit.php?post_type=' . $parentMenue,
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search'   =>  true,
            'query_var'             =>  true,
            'has_archive'           =>  false,
            'rewrite'               =>  false,
            'supports'              =>  ['title'],
        ]);
    }

    public static function tableName()
    {
        return '{{%yii2wp_templates}}';
    }

    public function rules()
    {
        return [
            [['title','templateContent'],'required'],
            ['title','unique']
        ];
    }

    public function afterDelete()
    {
        if (file_exists($this->getFilePath())) {
            unlink($this->getFilePath());
        }

        return parent::afterDelete();
    }

    public function beforeSave($insert)
    {
        if (in_array($this->wpPost->post_status, ['auto-draft','trash'])) {
            return false;
        }

        if ($this->templateContent) {
            $content = stripslashes(
                html_entity_decode($this->templateContent, ENT_QUOTES, 'UTF-8')
            );

            file_put_contents(
                $this->getFilePath(),
                $content
            );
        }

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if (file_exists($this->getFilePath())) {
            $this->templateContent = file_get_contents($this->getFilePath());
        }

        return parent::afterFind();
    }

    public static function getWpType(): string
    {
        return 'yii2wptpl';
    }

    public function getTabLabel(): string
    {
        return 'Template';
    }

    public function formFields(): array
    {
        return [
            [
                'attribute' => 'templateContent',
                'type' => DetailView::INPUT_TEXTAREA,
                'options' => ['style' => 'width: 100%;height:400px']
            ],
        ];
    }

    /**
     * Dont translate @-prefixed path here.
     * Otherwise, a controller is needed to locate the viewfile.
     * The View File *MUST* beginn with '@'
     * @see yii\base\View:172
     */
    public function getFilePath($resolve=true): string
    {
        $fileName = $this->wpPost ? StringHelper::standardize($this->wpPost->post_title) : $this->pid;

        $filePath = '@plugin/Templates/' . $fileName . '_' . $this->pid . '.php';

        if ($resolve) {
            return Yii::getAlias($filePath);
        }
        return $filePath;
    }
}
