<?php

namespace Database\Seeders;

use Database\Factories\ProductVariantFactory;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductVariantFactory::times(5)->create();
    }
}
