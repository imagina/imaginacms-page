<?php

namespace Modules\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use Translatable;

    protected $table = 'page__blocks';
    public $translatedAttributes = [
        'title',
        'description',
    ];
    protected $fillable = [
        'sort_order',
        'options',
        'page_id',
    ];

    protected $casts = [
        'options' => 'array'
    ];

    function page(){
        return $this->belongsTo(Page::class);
    }

    function components(){
        return $this->hasMany(Component::class);
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
