<?php

namespace App\Models;

class ToolProperty extends BaseModel
{
    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['tool_id', 'property_id', 'is_guest_allowed', 'value'];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
