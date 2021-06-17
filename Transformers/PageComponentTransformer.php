<?php


namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageComponentTransformer extends JsonResource
{

  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'module' => $this->when($this->module, $this->module),
      'name' => $this->when($this->name, $this->name),
      'sortOrder' => $this->when($this->sort_order, $this->sort_order),
      'width' => $this->when($this->width, $this->width),
      'options' => $this->when($this->options, $this->options),
      'params' => $this->when($this->options, $this->options),
      'block' => new PageBlockTransformer($this->whenLoaded('block')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    return $data;
  }
}
