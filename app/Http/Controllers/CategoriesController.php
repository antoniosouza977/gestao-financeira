<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Category;
use App\Validators\BaseValidator;
use App\Validators\CategoryValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected BaseValidator $validator;

    protected SaveModelAction $saveModelAction;

    protected string $indexRoute = '';

    public function __construct(
        CategoryValidator $validator,
        SaveModelAction $action
    ) {
        $this->validator = $validator;
        $this->saveModelAction = $action;
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['name', 'type']);

        return $this->baseStore(new Category, $data);
    }

    public function update(Category $category, Request $request): RedirectResponse
    {
        $data = $request->only(['name']);

        return $this->baseUpdate($category, $data);
    }

    public function checkToDelete(Category $category): JsonResponse
    {
        return new JsonResponse([
            'isUsed' => ($category->transactions()->count() > 0) || ($category->transactionPromises()->count() > 0),
        ]);
    }

    public function migrateToDestroy(Category $category, Request $request): RedirectResponse
    {
        $category->transactions()->update(['category_id' => $request->id]);
        $category->transactionPromises()->update(['category_id' => $request->id]);

        return $this->destroy($category);
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }

        $category->delete();

        return redirect()->back();
    }
}
