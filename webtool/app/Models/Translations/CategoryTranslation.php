<?php

namespace App\Models\Translations;

use App\Models\BaseModel;

class CategoryTranslation extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'meta_title', 'meta_description', 'title', 'description', 'icon'];
}
