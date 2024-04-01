<?php

namespace Modules\Page\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Icrud\Repositories\BaseCrudRepository;
use Modules\Core\Repositories\BaseRepository;
use Modules\Page\Entities\Page;

interface PageRepository extends BaseCrudRepository
{
  /**
   * Find the page set as homepage
   * @return object
   */
  public function findHomepage();


}
