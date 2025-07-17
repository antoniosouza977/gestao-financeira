<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoriesService;
use Illuminate\Http\JsonResponse;

class GetCategoriesToMigrateFromController extends Controller
{
    private CategoriesService $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function __invoke(Category $category): JsonResponse
    {
        $categories = $this->categoriesService->getExcept($category->id, $category->type);

        return new JsonResponse([
            'categories' => $categories,
        ]);

    }
}
