<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class GetCategoriesToMigrateFromController extends Controller
{
    public function __invoke(Category $category): JsonResponse
    {
        $categories = Category::query()
            ->where('id', '!=', $category->id)
            ->where('type', $category->type)
            ->get();


        return new JsonResponse([
            'categories' => $categories,
        ]);

    }
}
