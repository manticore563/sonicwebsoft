<?php

namespace App\Models\Translations;

use App\Models\BaseModel;

class PropertyTranslation extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['name', 'property_id', 'description'];
}
