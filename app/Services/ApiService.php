<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Entity;
use App\Models\Category;

class ApiService
{
    private const CATEGORY_ANIMALS = 'Animals';
    private const CATEGORY_SECURITY = 'Security';

    public function getAndStoreEntities()
    {
        $response = Http::get('http://web.archive.org/web/20240403172734/https://api.publicapis.org/entries');
        if ($response->successful()) {
            $data = $response->json();

            if (!isset($data['entries']) || !is_array($data['entries'])) {
                throw new \Exception('Invalid API response structure.');
            }

            $entries = $data['entries'];
            foreach ($entries as $entry) {
                if (in_array($entry['Category'], [self::CATEGORY_ANIMALS, self::CATEGORY_SECURITY])) {
                    $category = Category::firstOrCreate(['category' => $entry['Category']]);

                    Entity::create([
                        'api' => $entry['API'],
                        'description' => $entry['Description'],
                        'link' => $entry['Link'],
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
