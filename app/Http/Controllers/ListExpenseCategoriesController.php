<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Response;
use Inertia\ResponseFactory;

class ListExpenseCategoriesController extends Controller
{
    public function __invoke(): Response|ResponseFactory
    {
        $categories = Category::query()
            ->where('user_id', auth()->id())
            ->where('type', Category::EXPENSE)
            ->paginate(10);

        $type = Category::EXPENSE;

        return inertia('Categories/Index', compact('categories', 'type'));
    }
}
