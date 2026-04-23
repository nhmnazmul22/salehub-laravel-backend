<?php

namespace Tests\Feature;

use App\Mail\SendOtpMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
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
        Mail::fake();

        $data = [
            'email' => 'admin@salehub.com',
        ];
        // Act
        $response = $this->postJson(route('v1.auth.forgot-password'), $data);

        // Assert
        $response->assertStatus(200);
        Mail::assertSent(SendOtpMail::class, function ($mail) use ($data) {
            return $mail->hasTo($data['email']);
        });
        $this->assertTrue(Cache::has('password_reset_otp' . $data["email"]));
    }

    /**
     * User can generate refresh token
     */
    public function test_user_can_verify_OTP_CODE(): void
    {
        // Arrange
        $data = [
            'email' => 'admin@salehub.com',
            'otp' => '123456',
        ];
        Cache::put('password_reset_otp' . $data['email'], $data['otp'], now()->addMinute(5));

        // Act
        $response = $this->postJson(route('v1.auth.verify-otp', $data));

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'OTP verification successful'
        ]);
    }
}
