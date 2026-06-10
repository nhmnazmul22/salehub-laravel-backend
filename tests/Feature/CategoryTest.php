<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
    }

    /**
     * Test admin can create new category
     */
    public function test_admin_can_create_new_category(): void
    {
        // Arrange
        $payload = [
            'name' => "Electronics",
            'image' => "https://330px-Arduino_ftdi_chip-1.jpg",
        ];
        // Act
        $response = $this->withHeaders($this->authHeaders())
            ->postJson(route('v1.categories.store'), $payload);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => "Category successfully created"
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => "Electronics",
            'image' => "https://330px-Arduino_ftdi_chip-1.jpg",
        ]);
    }

    /**
     * Test admin can list category with children
     */
    public function test_admin_can_list_category_with_children()
    {
        // Arrange
        $category2 = Category::factory()->create(['parentId' => $this->category->categoryId]);
        Category::factory()->create(['parentId' => $category2->categoryId]);

        // Act
        $response = $this->withHeaders($this->authHeaders())
            ->get(route('v1.categories.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Category retrieved successfully'
        ]);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                "*" => [
                    'categoryId',
                    'cuid',
                    'name',
                    'image',
                    'isActive',
                    'children' => [
                        "*" => [
                            'categoryId',
                            'cuid',
                            'name',
                            'image',
                            'isActive',
                            'children' => [
                                '*' => [
                                    'categoryId',
                                    'cuid',
                                    'name',
                                    'image',
                                    'isActive',
                                    'created_at',
                                    'updated_at',
                                ]
                            ],
                            'created_at',
                            'updated_at',
                        ]
                    ],
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
    }
}
