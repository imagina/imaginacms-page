<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{

    protected $table = 'page__blocks';

    protected $fillable = [
        'sort_order',
        'width',
        'type',
        'component',
        'options',
        'position',
        'custom_html',
        'page_id',
    ];

    protected $casts = [
        'options' => 'array'
    ];

    function page(){
        return $this->belongsTo(Page::class);
    }

    public function getOptionsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }
}
