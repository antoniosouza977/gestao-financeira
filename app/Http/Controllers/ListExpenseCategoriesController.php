<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoriesService;
use Inertia\Response;
use Inertia\ResponseFactory;

class ListExpenseCategoriesController extends Controller
{
    private CategoriesService $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function __invoke(): Response|ResponseFactory
    {
        $type = Category::EXPENSE;
        $categories = $this->categoriesService->getAllWithDetails($type);

        return inertia('Categories/Index', compact('categories', 'type'));
    }
}
