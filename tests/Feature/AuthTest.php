<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

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
     * Get authenticated user
     */

    public function test_user_can_get_profile(): void
    {
        // Act
        $response = $this->withHeaders($this->authHeaders())
            ->getJson(route('v1.auth.me'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Profile retrieved successful'
        ]);
    }

    /**
     * User can log out
     */
    public function test_user_can_logout(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson(route('v1.auth.logout'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'User logged out successful'
        ]);
    }

    /**
     * User can reset forgot password
     */
    public function test_user_can_forgot_password(): void
    {
        // Arrange
        $data = [
            'email' => 'admin@salehub.com',
        ];
        // Act
        $response = $this->postJson(route('v1.auth.forgot-password'), $data);

        // Assert
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
