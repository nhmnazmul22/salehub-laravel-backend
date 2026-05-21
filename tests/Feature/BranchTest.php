<?php

namespace Tests\Feature;

use App\Models\Branch;
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


    /**
     * Test admin can list all Branches
     */
    public function test_admin_can_list_branch()
    {
        // Act
        $response = $this
            ->withHeaders($this->authHeaders())
            ->getJson(route('v1.branches.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Branch retrieved successful',
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'branchId',
                    'cuid',
                    'name',
                    'address',
                    'phone',
                    'email',
                    'contactPerson',
                    'isActive',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test admin can show the specific branch
     */

    public function test_admin_can_show_branch()
    {
        // Arrange
        $branch = Branch::factory()->create();
        // Act
        $response = $this
            ->withHeaders($this->authHeaders())
            ->getJson(route('v1.branches.show', [$branch->cuid]));
        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Branch retrieved successful',
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'branchId',
                'cuid',
                'name',
                'address',
                'phone',
                'email',
                'contactPerson',
                'isActive',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test admin can update branch
     */

    public function test_admin_can_update_branch()
    {
        // Arrange
        $branch = Branch::factory()->create();
        $updatePayload = [
            'name' => 'Dhaka branch',
            'address' => 'Demra, Dhaka',
            'isActive' => false,
        ];
        // Act
        $response = $this->withHeaders($this->authHeaders())->putJson();

        // Assert
    }
}
