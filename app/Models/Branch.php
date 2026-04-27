<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $primaryKey = 'branchId';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'contactPerson',
        'isActive',
    ];

}
