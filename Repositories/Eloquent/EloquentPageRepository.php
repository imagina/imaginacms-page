<?php

namespace Modules\Page\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Events\PageIsCreating;
use Modules\Page\Events\PageIsUpdating;
use Modules\Page\Events\PageWasCreated;
use Modules\Page\Events\PageWasDeleted;
use Modules\Page\Events\PageWasUpdated;
use Modules\Page\Repositories\PageRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentPageRepository extends EloquentCrudRepository implements PageRepository
{

  /**
   * Attribute to define default relations
   * all apply to index and show
   * index apply in the getItemsBy
   * show apply in the getItem
   * @var array
   */
  protected $with = ['all' => ['files'] ];

  /**
   * Find the page set as homepage
   * @return object
   */
  public function findHomepage()
  {
    return $this->model->where('is_home', 1)->first();
  }

  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {

    if (isset($filter->tagId)) {
      $query->whereTag($filter->tagId, "id");
    }

    //Order by
    if (isset($filter->order)) {
      $orderByField = $filter->order->field ?? 'created_at';//Default field
      $orderWay = $filter->order->way ?? 'desc';//Default way
      $query->orderBy($orderByField, $orderWay);//Add order to query
    }

    //add filter by search
    if (isset($filter->search) && $filter->search) {
      //find search in columns
      $term = $filter->search;
      $query->where(function ($query) use ($term, $filter) {
        $query->whereHas('translations', function ($query) use ($term, $filter) {
          $query->where('title', 'LIKE', "%{$term}%");
          $query->orWhere('body', 'LIKE', "%{$term}%");
          $query->orWhere('slug', 'LIKE', "%{$term}%");
          $words = explode(' ', trim($filter->search));

          //queryng word by word
          if (count($words) > 1)
            foreach ($words as $index => $word) {
              if (strlen($word) >= ($filter->minCharactersSearch ?? 3)) {
                $query->orWhere('title', 'like', "%" . $word . "%")
                  ->orWhere('body', 'like', "%" . $word . "%");
              }
            }//foreach

        })->orWhere(function ($query) use ($term) {
          $query->whereTag($term, 'name');
        })->orWhere('id', $term);
      });
    }

    $entitiesWithCentralData = json_decode(setting("isite::tenantWithCentralData", null, "[]",true));
    $tenantWithCentralData = in_array("page", $entitiesWithCentralData);


    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;

      //If an organization is in the Iadmin, just show them their information
      //For the administrator does not apply because he has no organization
      // filter->type=="cms" - When they reload the iadmin they make a request looking for the cms types
      if ((isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin==false) || (isset($filter->type) && $filter->type=="cms") ) {
        $query->withoutTenancy();
      }

      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }
    return $query;
  }


  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);

    /**
     * Note: Add relation name to replaceSyncModelRelations attribute to replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */

    //Response
    return $model;
  }


    public function updateBy($criteria, $data, $params = false)
    {

      $query = $this->model->query();

      //Event updating model
      if (method_exists($this->model, 'updatingCrudModel'))
        $this->model->updatingCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);


      if (isset($params->filter)) {
        $filter = $params->filter;

        //Update by field
        if (isset($filter->field))
          $field = $filter->field;
      }


      $model = $query->where($field ?? 'id', $criteria)->first();

      if (isset($model->id)) {

        if (Arr::get($data, 'is_home') === '1') {
          $this->removeOtherHomepage($model->id);
        }

        event($event = new PageIsUpdating($model, $data));

        //force it into the system name setter
        if(empty($data["system_name"]))
          $data["system_name"] = $model->system_name;

        $model->update($data);

        //Event updated model
        if (method_exists($model, 'updatedCrudModel'))
          $model->updatedCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);

        event(new PageWasUpdated($model, $data));

        return $model;

      }
      return false;
    }


    public function deleteBy($criteria, $params = false)
    {

      $query = $this->model->query();


      if (isset($params->filter)) {
        $filter = $params->filter;

        if (isset($filter->field))//Where field
          $field = $filter->field;
      }


      $model = $query->where($field ?? 'id', $criteria)->first();

      if (isset($model->id)) {
        $model->untag();

        event(new PageWasDeleted($model));

        return $model->delete();

      }
      return false;
    }


}
