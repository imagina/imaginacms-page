<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Transformers\FullPageTransformer;
use Modules\Page\Transformers\PageApiTransformer;
use Modules\Page\Transformers\PageTransformer;

class PageApiController extends BaseCrudController
{
  /**
   * @var PageRepository
   */
  private $repoEntity;

  public function __construct(PageRepository $page)
  {
    $this->repoEntity = $page;
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function indexCMS(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Add filters
      $params->filter = (object)array_merge((array)$params->filter, [
        "type" => "cms",
        "allTranslations" => true
      ]);

      //Add the Request All Pages param to request
      $params->allowIndexAll = true;

      //Request to Repository
      $dataEntity = $this->repoEntity->getItemsBy($params);

      //Response
      $response = [
        "data" => PageApiTransformer::collection($dataEntity)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

}
