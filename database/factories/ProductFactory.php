<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
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
        $user = User::where('role', 'admin')->first();
        $category = CategoryFactory::new()->create();
        $unit = UnitFactory::new()->create();
        $brand = BrandFactory::new()->create();

        return [
            'name' => fake()->sentence(),
            'slug' => fake()->slug(),
            'uuid' => Str::uuid(),
            'categoryId' => $category->categoryId,
            'unitId' => $unit->unitId,
            'brandId' => $brand->brandId,
            'description' => fake()->text(),
            'imageUrl' => fake()->imageUrl,
            'createdBy' => $user->id,
        ];
    }
}
