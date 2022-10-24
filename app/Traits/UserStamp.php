<?php

namespace App\Traits;

use App\Observers\UserStampObserver;

trait UserStamp
{
    public static function boot()
    {
        parent::boot();
        static::observe(UserStampObserver::class);
    }
}
