<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class WidgetArea extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'description', 'order'
    ];

    /**
     * WidgetArea has many widgets
     *
     * @return collection
     */
    public function widgets()
    {
        return $this->hasMany(Widget::class, 'widget_area_id', 'id')->orderBy('order', 'ASC');
    }
}
