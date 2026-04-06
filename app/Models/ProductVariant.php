<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
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
