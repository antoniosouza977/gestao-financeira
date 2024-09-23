<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Response;
use Inertia\ResponseFactory;

class ListIncomeCategoriesController extends Controller
{
    public function __invoke(): Response|ResponseFactory
    {
        $categories = Category::query()
            ->where('user_id', auth()->id())
            ->where('type', Category::INCOME)
            ->paginate(10);

        $type = Category::INCOME;

        return inertia('Categories/Index', compact('categories', 'type'));
    }
}
