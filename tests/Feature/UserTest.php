<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
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
            'branchId' => 1,
        ];
        // Act
        // Assert

    }
}
