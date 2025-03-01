<?php

namespace App\Models\Translations;

use App\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolTranslation extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'content', 'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'index_content'];
}
