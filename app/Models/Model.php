<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as MainModel;
use Visus\Cuid2\Cuid2;

class Model extends MainModel
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->cuid)) {
                $size = config('app.cuid_size', 24);

                $model->cuid = new Cuid2(
                    maxLength: ($size < 4 || $size > 32) ? 24 : $size
                )->toString();
            }
        });

    }
}
