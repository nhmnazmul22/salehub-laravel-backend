<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = UserFactory::new()->create();
        $category = CategoryFactory::new()->create();
        $unit = UnitFactory::new()->create();
        $brand = BranchFactory::new()->create();

        return [
            'name' => fake()->sentence(),
            'slug' => fake()->slug(),
            'uuid' => Str::uuid(),
            'categoryId' => $category->categoryId,
            'unitId' => $unit->unitId,
            'brandId' => $brand->branchId,
            'description' => fake()->text(),
            'imageUrl' => fake()->imageUrl,
            'createdBy' => $user->id,
        ];
    }
}
