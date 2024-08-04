<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_entity()
    {
        $category = Category::factory()->create();

        $entity = Entity::create([
            'api' => 'https://api.example.com',
            'description' => 'Example description',
            'link' => 'https://example.com',
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('entities', [
            'api' => 'https://api.example.com',
            'description' => 'Example description',
            'link' => 'https://example.com',
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $entity = Entity::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Category::class, $entity->category);
        $this->assertEquals($category->id, $entity->category->id);
    }
}
