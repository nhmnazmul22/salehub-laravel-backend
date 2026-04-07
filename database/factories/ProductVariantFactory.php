<?php

namespace Database\Factories;

use App\Enums\DiscountType;
use App\Enums\VatType;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{

    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $product = Product::first();
        $user = User::where('role', 'admin')->inRandomOrder()->first();

        return [
            'sku' => Str::slug(fake()->sentence(3)),
            'productId' => $product->productId,
            'purchasePrice' => fake()->randomElement([100, 200, 300, 500]),
            'unitPrice' => fake()->randomElement([100, 200, 300, 500]),
            'sellPrice' => fake()->randomElement([100, 200, 300, 500]),
            'lastUnitPrice' => fake()->randomElement([100, 200, 300, 500]),
            'shippingAmount' => fake()->randomElement([100, 200, 300, 500]),
            'discountEnabled' => fake()->boolean(),
            'discountType' => fake()->randomElement(DiscountType::cases()),
            'discountAmount' => fake()->randomElement([100, 200, 300, 500]),
            'vatEnabled' => fake()->boolean(),
            'vatType' => fake()->randomElement(VatType::cases()),
            'vatAmount' => fake()->randomElement([100, 200, 300, 500]),
            'createdBy' => $user->id,
            'isActive' => fake()->boolean(),
        ];
    }
}
