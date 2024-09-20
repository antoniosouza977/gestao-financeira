<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\ExpenseCategory;
use App\Validators\BaseValidator;
use App\Validators\ExpenseCategoryValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ExpenseCategoriesController extends Controller
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected string $indexRoute = 'expense-categories.index';

    public function __construct(SaveModelAction $saveModelAction, ExpenseCategoryValidator $validator)
    {
        $this->saveModelAction = $saveModelAction;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        $categories = ExpenseCategory::query()
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })->paginate(10);

        return inertia()->render('ExpenseCategories/Index', compact('categories'));
    }

    public function create(): Response
    {
        return inertia()->render('ExpenseCategories/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['name']);
        return $this->baseStore(new ExpenseCategory(), $data);
    }

    public function show(ExpenseCategory $expenseCategory): Response
    {
        return $this->edit($expenseCategory);
    }

    public function edit(ExpenseCategory $expenseCategory): Response
    {
        return inertia()->render('ExpenseCategories/Form', ['category' => $expenseCategory]);
    }

    public function update(Request $request, ExpenseCategory $expenseCategory): RedirectResponse
    {
        $data = $request->only(['name']);
        return $this->baseUpdate($expenseCategory, $data);
    }

    public function destroy(ExpenseCategory $expenseCategory): RedirectResponse
    {
        if ($expenseCategory->user_id !== auth()->id()) {
            abort(403);
        }

        $expenseCategory->load('expenses');
        if ($expenseCategory->expenses->isNotEmpty()) {
            $expenseCategory->expenses()->update(['category_id' => ExpenseCategory::DEFAULT_ID]);
        }

        $expenseCategory->delete();
        return redirect()->route($this->indexRoute);
    }
}
