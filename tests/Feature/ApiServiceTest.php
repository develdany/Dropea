<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entity;
use App\Services\ApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_and_store_entities()
    {
        Http::fake([
            'http://web.archive.org/web/20240403172734/https://api.publicapis.org/entries' => Http::response([
                'entries' => [
                    [
                        'API' => 'Test API 1',
                        'Description' => 'Test Description 1',
                        'Link' => 'http://test.com/1',
                        'Category' => 'Animals',
                    ],
                    [
                        'API' => 'Test API 2',
                        'Description' => 'Test Description 2',
                        'Link' => 'http://test.com/2',
                        'Category' => 'Security',
                    ],
                    [
                        'API' => 'Test API 3',
                        'Description' => 'Test Description 3',
                        'Link' => 'http://test.com/3',
                        'Category' => 'Other',
                    ],
                ],
            ]),
        ]);

        $apiService = new ApiService();
        $apiService->getAndStoreEntities();

        $this->assertDatabaseHas('categories', ['category' => 'Animals']);
        $this->assertDatabaseHas('categories', ['category' => 'Security']);

        $this->assertDatabaseHas('entities', [
            'api' => 'Test API 1',
            'description' => 'Test Description 1',
            'link' => 'http://test.com/1',
            'category_id' => Category::where('category', 'Animals')->first()->id,
        ]);
        $this->assertDatabaseHas('entities', [
            'api' => 'Test API 2',
            'description' => 'Test Description 2',
            'link' => 'http://test.com/2',
            'category_id' => Category::where('category', 'Security')->first()->id,
        ]);

        $this->assertDatabaseMissing('entities', [
            'api' => 'Test API 3',
            'description' => 'Test Description 3',
            'link' => 'http://test.com/3',
        ]);
    }
}
