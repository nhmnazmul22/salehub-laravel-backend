<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'categoryId';

    protected $fillable = [
        'name',
        'image',
        'parentId',
        'isActive',
        'deleted_at'
    ];

    protected $casts = [
        'isActive' => 'boolean'
    ];

    public function getRouteKeyName(): string
    {
        return 'cuid';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parentId', 'categoryId');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parentId', 'categoryId')
            ->with('children');
    }

}
