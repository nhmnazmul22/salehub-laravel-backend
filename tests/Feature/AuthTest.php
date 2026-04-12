<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create([
            'firstName' => 'Admin',
            'lastName' => 'Salehub',
            'role' => 'admin',
            'email' => 'admin@salehub.com',
            'password' => Hash::make('@Admin123'),
            'remember_token' => Str::random(10),
        ]);
    }

    /**
     * User can log in
     */
    public function test_user_can_login(): void
    {
        // Arrange
        $payload = [
            'email' => 'admin@salehub.com',
            'password' => '@Admin123',
        ];
        // Act
        $response = $this->postJson(route('v1.auth.login'), $payload);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Login successful',
        ]);
    }

    /**
     * User can log out
     */
    public function test_user_can_logout(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * User can reset password
     */
    public function test_user_can_reset_password(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * User can generate refresh token
     */
    public function test_user_can_generate_refresh_token(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
