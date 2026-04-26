<?php


namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{


    /**
     * Run the database seed
     */

    public function run(): void
    {
        $users = [
            [
                'firstName' => 'salehub',
                'lastName' => 'admin',
                'role' => 'admin',
                'email' => 'salehub_admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('@Admin123'),
                'remember_token' => Str::random(10),
                'last_login' => now(),
            ],
            [
                'firstName' => 'nhm',
                'lastName' => 'nazmul',
                'role' => 'admin',
                'email' => 'nhmnazmul87@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('@Admin123'),
                'remember_token' => Str::random(10),
                'last_login' => now(),
            ]
        ];

        foreach ($users as $user) {
            UserFactory::new()->create($user);
        }
    }
}
