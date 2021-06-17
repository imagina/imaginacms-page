<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;

class ComponentTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'params'
    ];

    protected $casts = [
        'params' => 'array'
    ];

    protected $table = 'page__component_translations';

    public function getParamsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }
}
