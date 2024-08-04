<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_entities_for_existing_category()
    {
        $category = Category::factory()->create(['category' => 'Animals']);

        $entity1 = Entity::factory()->create([
            'api' => 'Test API 1',
            'description' => 'Test Description 1',
            'link' => 'http://test.com/1',
            'category_id' => $category->id,
        ]);
        $entity2 = Entity::factory()->create([
            'api' => 'Test API 2',
            'description' => 'Test Description 2',
            'link' => 'http://test.com/2',
            'category_id' => $category->id,
        ]);
        $response = $this->get('/api/Animals');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'data' => [
                [
                    'api' => $entity1->api,
                    'description' => $entity1->description,
                    'link' => $entity1->link,
                    'category' => [
                        'id' => $category->id,
                        'category' => $category->category,
                    ],
                ],
                [
                    'api' => $entity2->api,
                    'description' => $entity2->description,
                    'link' => $entity2->link,
                    'category' => [
                        'id' => $category->id,
                        'category' => $category->category,
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_returns_not_found_for_non_existing_category()
    {
        $response = $this->get('/api/OtherCategory');

        $response->assertStatus(404);

        $response->assertJson([
            'success' => false,
            'message' => 'Category not found',
        ]);
    }
}
