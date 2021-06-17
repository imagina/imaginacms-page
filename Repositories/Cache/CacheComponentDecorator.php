<?php

namespace Modules\Page\Repositories\Cache;

use Modules\Page\Repositories\ComponentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheComponentDecorator extends BaseCacheDecorator implements ComponentRepository
{
    public function __construct(ComponentRepository $component)
    {
        parent::__construct();
        $this->entityName = 'page.components';
        $this->repository = $component;
    }

    /**
     * List or resources
     *
     * @param $params
     * @return collection
     */
    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }


    /**
     * find a resource by id or slug
     *
     * @param $criteria
     * @param $params
     * @return object
     */
    public function getItem($criteria, $params)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }


    /**
     * create a resource
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $this->clearCache();
        return $this->repository->create($data);
    }

    /**
     * update a resource
     *
     * @param $criteria
     * @param $data
     * @param $params
     * @return mixed
     */
    public function updateBy($criteria, $data, $params)
    {
        $this->clearCache();

        return $this->repository->updateBy($criteria, $data, $params);
    }

    /**
     * destroy a resource
     *
     * @param $criteria
     * @param $params
     * @return mixed
     */
    public function deleteBy($criteria, $params)
    {
        $this->clearCache();

        return $this->repository->deleteBy($criteria, $params);
    }
}
