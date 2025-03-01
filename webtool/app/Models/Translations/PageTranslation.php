<?php

namespace App\Models\Translations;

use App\Models\BaseModel;

class PageTranslation extends BaseModel
{
    public $timestamps = false;

    protected $table = 'page_translations';

    protected $fillable = ['title', 'slug', 'content', 'excerpt', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image'];
}
