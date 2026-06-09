<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private Branch $branch;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->branch = Branch::factory()->create();
        $this->user = User::factory()->create();

        $this->seed([
            UserSeeder::class
        ]);
    }

    /**
     * Test admin can create new user
     */
    public function test_admin_can_create_new_user(): void
    {
        // Arrange
        $payload = [
            'firstName' => 'new_staff',
            'lastName' => 'salehub',
            'role' => 'staff',
            'email' => 'staff@gamil.com',
            'password' => '@Staff_salehub22',
            'branchId' => $this->branch,
        ];
        // Act
        $result = $this->withHeaders($this->authHeaders())
            ->postJson(route('v1.users.store'), $payload);

        // Assert
        $result->assertStatus(201);
        $result->assertJson([
            'success' => true,
            'message' => 'User created successful',
        ]);

    }

    /**
     * Test admin can list the users
     */
    public function test_admin_can_list_users(): void
    {
        // Act
        $result = $this->withHeaders($this->authHeaders())
            ->getJson(route('v1.users.index'));

        // Assert
        $result->assertStatus(200);
        $result->assertJson([
            'success' => true,
            'message' => 'Users retrieved successful'
        ]);
    }

    /**
     * Test admin can get user by CUID
     */

    public function test_admin_can_get_user_by_CUID()
    {
        // Act
        $result = $this->withHeaders($this->authHeaders())
            ->getJson(route('v1.users.show', [$this->user->cuid]));
        // Assert
        $result->assertStatus(200);
        $result->assertJson([
            'success' => true,
            'message' => 'User retrieved successful'
        ]);
    }
}
