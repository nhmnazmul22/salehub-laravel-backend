<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as MainModel;
use Schema;
use Visus\Cuid2\Cuid2;

class Model extends MainModel
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            // Check if the model's table has a 'cuid' column to avoid errors
            // and if a cuid has not already been set manually.
            if (empty($model->cuid) && Schema::hasColumn($model->getTable(), $model->cuid)) {

                // Your provided logic for generating the CUID.
                // We use a fixed size of 24 here as a sensible default.
                $size = config('app.cuid_size', 24);
                $model->cuid = new Cuid2(maxLength: ($size < 4 || $size > 32) ? 24 : $size)->toString();
            }
        });

    }
}
