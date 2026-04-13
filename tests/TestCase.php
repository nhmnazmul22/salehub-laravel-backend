<?php

namespace Tests;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    protected User $adminUser;
    protected string $adminUserToken;


    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = UserFactory::new()->create([
            'firstName' => 'Admin',
            'lastName' => 'Salehub',
            'role' => 'admin',
            'email' => 'admin@salehub.com',
            'password' => Hash::make('@Admin123'),
            'remember_token' => Str::random(10),
        ]);
        $this->adminUserToken = JWTAuth::fromUser($this->adminUser);
    }

    protected function authHeaders(array $additional = []): array
    {
        return array_merge([
            'Authorization' => 'Bearer ' . $this->adminUserToken,
        ], $additional);
    }
}
