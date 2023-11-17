<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Ifillable\Transformers\FieldTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

class PageApiTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    $data = [

      'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
      'urls' => [
        'deleteUrl' => route('api.page.page.destroy', $this->resource->id),
      ],
      'url' => $this->url
    ];

    foreach ($this->tags as $tag) {
      $data['tags'][] = $tag->name;
    }

    //Set layoutId over the fiellable
    $data["layoutId"] = $this->layoutId;

    //Response
    return $data;
  }
}
