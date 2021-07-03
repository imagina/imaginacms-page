<?php


namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageBlockTransformer extends JsonResource
{

  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'sortOrder' => $this->when($this->sort_order, $this->sort_order),
      'width' => $this->when($this->width, $this->width),
      'type' => $this->when($this->type, $this->type),
      'component' => $this->when($this->component, $this->component),
      'position' => $this->when($this->position, $this->position),
      'options' => $this->when($this->options, $this->options),
      'customHtml' => $this->when($this->custom_html, $this->custom_html),
      'page' => new PageApiTransformer($this->whenLoaded('page')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    return $data;
  }
}
