<?php

namespace App\Traits;

use App\Observers\ModelObserver;

trait ModelObservant
{
    public static function bootModelObservant(): void
    {
        static::observe(new ModelObserver);
    }
}
