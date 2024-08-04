<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getEntitiesByCategory(string $categoryName): JsonResponse
    {
        $category = Category::where('category', $categoryName)->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $entities = $category->entities;

        $data = $entities->map(function ($entity) {
            return [
                'api' => $entity->api,
                'description' => $entity->description,
                'link' => $entity->link,
                'category' => [
                    'id' => $entity->category->id,
                    'category' => $entity->category->category,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
