<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can create branch
     */

    public function test_admin_can_create_branch()
    {
        // Arrange
        $payload = [
            'name' => 'Dhaka branch',
            'address' => 'Demra, Dhaka',
            'phone' => '+8801605485455',
            'email' => 'dhakabranch@gmail.com',
            'contactPerson' => '+4787454465'
        ];
        //Act
        $response = $this->withHeaders($this->authHeaders())
            ->postJson(route('v1.branches.store'), $payload);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Branch created successful',
        ]);
    }


}
