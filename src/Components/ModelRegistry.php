<?php

declare(strict_types=1);

namespace winternet\yii2wordpress\Components;

use Yii;
use yii\base\Component;
use winternet\yii2wordpress\Interfaces\WpPostInterface;

/**
 * Model registry holds all models which are affected by WordPress CRUD-Operations.
 * In fact, the basic AR-Operations such like load(), save(), findByPostId() are available
 * in Batch-Mode for all registered Models.
 */
class ModelRegistry extends Component
{
    /**
     * @var WpPostInterface[]
     */
    private $registry = [];

    /**
     * @var String[] process only Models attached to this post types
     * @see WpPostInterface
     */
    private $postTypes = [];

    /**
     * Process only models attached to this Type.
     *
     * @param mixed $type array|string|null null disables this filter
     *
     * @return ModelRegistry
     */
    public function filterPostType($types=null): ModelRegistry
    {
        if (is_string($types)) {
            $types = [$types];
        }

        $this->postTypes = $types;

        return $this;
    }

    /**
     * whether the registry holds Models assigned to this wp post types
     *
     * @param string|array post types to check
     *
     * @return bool
     */
    public function hasPostType($types): bool
    {
        if (is_string($types)) {
            $types = [$types];
        }

        return $this->get($types) ? true : false;
    }

    public function setPostId($postId): ModelRegistry
    {
        foreach ($this->getInternal($this->postTypes) as $model) {
            $model->pid = $postId;
        }

        return $this;
    }

    /**
     * adds a Model to the registry
     *
     * @param Model $model the model instance
     */
    public function add(WpPostInterface $model): ModelRegistry
    {
        $this->registry[get_class($model)] = $model;

        return $this;
    }

    /**
     * get all Models from registry.
     *
     * @param array $types posttypes to return
     *
     * @return array of Model instances.
     */
    protected function getInternal(array $types=null): array
    {
        if ($types && is_array($types)) {
            $registry = [];
            foreach ($this->registry as $model) {
                if (in_array($model->getWpType(), $types)) {
                    $registry[get_class($model)] = $model;
                }
            }
            return $registry;
        }

        return $this->registry;
    }

    public function get(): array
    {
        return $this->getInternal($this->postTypes);
    }

    /**
     * adds multiple Model in Batch
     * @see [add]
     */
    public function addMultiple(array $models): ModelRegistry
    {
        foreach ($models as $model) {
            $this->add($model);
        }

        return $this;
    }

    public function load($data): ModelRegistry
    {
        foreach ($this->getInternal($this->postTypes) as $model) {
            $model->load($data);
        }

        return $this;
    }

    public function findByPostId($postId): ModelRegistry
    {
        foreach ($this->getInternal($this->postTypes) as $key => $model) {
            $finder = $model::find();
            $populatedAr = $finder->andWhere(['pid' => $postId])->one();
            if ($populatedAr) {
                $this->registry[$key] = $populatedAr;
            }
        }

        return $this;
    }

    public function persist($validate=true, array $types=[]): ModelRegistry
    {
        foreach ($this->getInternal($this->postTypes) as $model) {
            $model->save($validate);
        }

        return $this;
    }

    public function validate(): ModelRegistry
    {
        foreach ($this->getInternal($this->postTypes) as $model) {
            $model->validate();
        }

        return $this;
    }
}
