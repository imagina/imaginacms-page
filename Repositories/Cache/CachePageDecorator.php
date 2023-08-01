<?php

namespace Modules\Page\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;

class CachePageDecorator extends BaseCacheCrudDecorator implements PageRepository
{
    /**
     * @var PageRepository
     */
    protected $repository;

    public function __construct(PageRepository $page)
    {
        parent::__construct();
        $this->entityName = 'pages';
        $this->repository = $page;
    }
  
    /**
   * Find the page set as homepage
   *
   * @return object
   */
  public function findHomepage()
  {
    return $this->remember(function () {
      return $this->repository->findHomepage();
    });
  }
  

}
