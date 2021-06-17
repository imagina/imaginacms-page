<?php


namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageBlockTransformer extends JsonResource
{

  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'description' => $this->when($this->description, $this->description),
      'sortOrder' => $this->when($this->sort_order, $this->sort_order),
      'width' => $this->when($this->width, $this->width),
      'options' => $this->when($this->options, $this->options),
      'components' => PageComponentTransformer::collection($this->whenLoaded('components')),
      'page' => new PageApiTransformer($this->whenLoaded('page')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    $filter = json_decode($request->filter);
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ? $this->translate("$lang")['title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ? $this->translate("$lang")['description'] : '';
      }
    }

    return $data;
  }
}
