<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;

class BlockTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'page__block_translations';
}
