<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'products_variants';
    protected $primaryKey = 'productVariantId';

    protected $fillable = [
        'sku',
        'productId',
        'purchasePrice',
        'unitPrice',
        'sellPrice',
        'lastUnitPrice',
        'shippingAmount',
        'discountEnabled',
        'discountType',
        'discountAmount',
        'vatEnabled',
        'vatType',
        'vatAmount',
        'createdBy',
        'isActive',
        'deletedAt',
    ];
}
