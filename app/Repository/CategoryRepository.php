<?php

namespace App\Repository;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository
{
    public function __construct(protected Category $category)
    {
    }

    public function createCategory(array $attributes): Category
    {
        return $this->category->create($attributes);
    }

    public function findCategoryWithChildren(): Collection
    {
        return $this->category
            ->whereNull('parentId')
            ->with('children')
            ->get();
    }
}
