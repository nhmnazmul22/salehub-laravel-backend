<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'productId';

    protected $fillable = [
        'name',
        'slug',
        'categoryId',
        'brandId',
        'unitId',
        'basePrice',
        'discountType',
        'discountAmount',
        'vatType',
        'vatAmount',
        'description',
        'imageUrl',
        'isActive',
        'createdBy'
    ];


    protected static function booted(): void
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

}
