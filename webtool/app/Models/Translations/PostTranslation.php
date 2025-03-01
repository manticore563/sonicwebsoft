<?php

namespace App\Models\Translations;

use App\Models\BaseModel;

class PostTranslation extends BaseModel
{
    protected $table = 'post_translations';

    protected $fillable = ['title', 'slug', 'contents', 'meta_title', 'meta_description', 'og_title', 'og_description', 'excerpt'];
}
