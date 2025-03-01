<?php

namespace App\Models;

use App\Traits\ClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseModel extends Model
{
    use ClearCache, HasFactory;

    /**
     * Bootstrap any application services.
     */
    public static function boot(): void
    {
        parent::boot();
        self::bootClearsResponseCache();
    }
}
