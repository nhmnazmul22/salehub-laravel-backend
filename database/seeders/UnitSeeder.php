<?php

namespace Database\Seeders;

use Database\Factories\UnitFactory;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'key' => 'ltr',
                'value' => 1,
            ],
            [
                'key' => 'ml',
                'value' => 0.001,
            ],
            [
                'key' => 'kg',
                'value' => 1,
            ],
            [
                'key' => 'gm',
                'value' => 0.001,
            ],
            [
                'key' => 'pcs',
                'value' => 1,
            ],
        ];

        foreach ($units as $unit) {
            UnitFactory::new()->create($unit);
        }
    }
}
