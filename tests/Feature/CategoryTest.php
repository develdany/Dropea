<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_category()
    {
        $category = Category::create([
            'category' => 'Sample Category',
        ]);

        $this->assertDatabaseHas('categories', [
            'category' => 'Sample Category',
        ]);
    }

    /** @test */
    public function it_can_have_many_entities()
    {
        $category = Category::factory()->create();
        $entity1 = Entity::factory()->create(['category_id' => $category->id]);
        $entity2 = Entity::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->entities->contains($entity1));
        $this->assertTrue($category->entities->contains($entity2));
    }
}
