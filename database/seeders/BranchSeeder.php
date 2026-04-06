<?php

namespace Database\Seeders;

use Database\Factories\BranchFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    /**
     * Seed the branch table.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Dhaka Branch',
                'address' => 'Sarulia, Demra, Dhaka',
                'phone' => '+8801604017164',
                'email' => 'support.dhaka-branch@gmail.com',
                'contactPerson' => '+8801604017164',
            ],
            [
                'name' => 'Chattogram Branch',
                'address' => 'Agrabad Commercial Area, Chattogram',
                'phone' => '+8801701123456',
                'email' => 'support.ctg@company.com',
                'contactPerson' => '+8801701123456',
            ],
            [
                'name' => 'Sylhet Branch',
                'address' => 'Zindabazar, Sylhet',
                'phone' => '+8801712233445',
                'email' => 'support.sylhet@company.com',
                'contactPerson' => '+8801712233445',
            ],
            [
                'name' => 'Khulna Branch',
                'address' => 'KDA Avenue, Khulna',
                'phone' => '+8801723344556',
                'email' => 'support.khulna@company.com',
                'contactPerson' => '+8801723344556',
            ],
            [
                'name' => 'Rajshahi Branch',
                'address' => 'Shaheb Bazar, Rajshahi',
                'phone' => '+8801734455667',
                'email' => 'support.rajshahi@company.com',
                'contactPerson' => '+8801734455667',
            ],
            [
                'name' => 'Barishal Branch',
                'address' => 'Sadar Road, Barishal',
                'phone' => '+8801745566778',
                'email' => 'support.barishal@company.com',
                'contactPerson' => '+8801745566778',
            ],
        ];

        foreach ($branches as $branch) {
            BranchFactory::new()->create([
                'uuid' => Str::uuid(),
                'name' => $branch['name'],
                'address' => $branch['address'],
                'phone' => $branch['phone'],
                'email' => $branch['email'],
                'contactPerson' => $branch['contactPerson'],
            ]);
        }
    }
}
