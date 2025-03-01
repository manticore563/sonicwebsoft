<?php

namespace App\Models\Translations;

use App\Models\BaseModel;

class TagTranslation extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'title', 'description'];
}
