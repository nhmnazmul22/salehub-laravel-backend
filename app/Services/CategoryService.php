<?php

namespace App\Services;


use App\Models\Category;
use App\Repository\CategoryRepository;
use Illuminate\Support\Collection;

class CategoryService extends BaseService
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function createNewCategory(array $attributes): Category
    {
        return $this->categoryRepository->createCategory($attributes);
    }

    public function getCategoryList(): Collection
    {
        return $this->categoryRepository->findCategoryWithChildren();
    }
}
