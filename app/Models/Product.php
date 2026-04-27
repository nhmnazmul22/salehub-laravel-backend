<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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


}
