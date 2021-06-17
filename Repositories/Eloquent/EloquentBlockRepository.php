<?php

namespace Modules\Page\Repositories\Eloquent;

use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Page\Repositories\BlockRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentBlockRepository extends EloquentBaseRepository implements BlockRepository
{
    /**
     * Standard Api Method
     * @param bool $params
     * @return mixed
     */
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter

            if (isset($filter->search)) { //si hay que filtrar por rango de precio
                $criterion = $filter->search;
                $param = explode(' ', $criterion);
                $criterion = $filter->search;
                //find search in columns
                $query->where(function ($query) use ($filter, $criterion) {
                    $query->whereHas('translations', function (Builder $q) use ($criterion) {
                        $q->where('title', 'like', "%{$criterion}%");
                    });
                })->orWhere('id', 'like', '%' . $filter->search . '%');
            }


            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            if(isset($filter->page)){
                $query->where('page_id',$filter->page);
            }

            if (isset($filter->ids)) {
                is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
                $query->whereIn('iform__blocks.id', $filter->ids);
            }
            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }

    /**
     * Standard Api Method
     * @param $criteria
     * @param bool $params
     * @return mixed
     */
    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }
        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;

            if(isset($filter->onlyTrashed) && $filter->onlyTrashed){
                $query->onlyTrashed();
            }

            if(isset($filter->withTrashed) && $filter->withTrashed){
                $query->withTrashed();
            }

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

            // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                        ->where($field, $criteria);
                });
            else
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->first();
    }

    /**
     * Standard Api Method
     * @param $data
     * @return mixed
     */
    public function create($data)
    {

        $model = $this->model->create($data);

        return $model;
    }


    /**
     * Standard Api Method
     * @param $criteria
     * @param $data
     * @param bool $params
     * @return bool
     */
    public function updateBy($criteria, $data, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            //Update by field
            if (isset($filter->field))
                $field = $filter->field;
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
        $model ? $model->update((array)$data) : false;
        event(new UpdateMedia($model, $data));
    }

    /**
     * Standard Api Method
     * @param $criteria
     * @param bool $params
     */
    public function deleteBy($criteria, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();
        $restore = false;

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Where field
                $field = $filter->field;
            if(isset($filter->restore))
                $restore = $filter->restore;
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->withTrashed()->first();
        if($model) {
            $restore === true ? $model->restore() : $model->delete();
            $restore === true ?: event(new DeleteMedia($model->id, get_class($model)));
        }

    }
}
