<?php

namespace Modules\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Translatable;

    protected $table = 'page__components';

    public $translatedAttributes = [
        'params'
    ];

    protected $fillable = [
        'module',
        'name',
        'sort_order',
        'width',
        'options',
        'block_id',
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function block(){
        return $this->belongsTo(Block::class);
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
