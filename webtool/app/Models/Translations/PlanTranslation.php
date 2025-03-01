<?php

namespace App\Models\Translations;

use App\Models\BaseModel;

class PlanTranslation extends BaseModel
{
    public $timestamps = false;

    protected $fillable = ['name', 'plan_id', 'description'];
}
