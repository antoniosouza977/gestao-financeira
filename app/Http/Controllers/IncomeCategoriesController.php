<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\IncomeCategory;
use App\Validators\BaseValidator;
use App\Validators\IncomeCategoryValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class IncomeCategoriesController extends Controller
{
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'income-categories.index';

    public function __construct
    (
        IncomeCategoryValidator $validator,
        SaveModelAction         $action)
    {
        $this->validator = $validator;
        $this->saveModelAction = $action;
    }

    public function index(): Response
    {
        $categories = IncomeCategory::query()
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })->paginate(10);

        return inertia()->render('IncomeCategories/Index', compact('categories'));
    }

    public function create(): Response
    {
        return inertia()->render('IncomeCategories/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['name']);
        return $this->baseStore(new IncomeCategory(), $data);
    }

    public function show(IncomeCategory $incomeCategory): Response
    {
        return $this->edit($incomeCategory);
    }

    public function edit(IncomeCategory $incomeCategory): Response
    {
        return inertia()->render('IncomeCategories/Form', ['category' => $incomeCategory]);
    }

    public function update(IncomeCategory $incomeCategory, Request $request): RedirectResponse
    {
        $data = $request->only(['name']);
        return $this->baseUpdate($incomeCategory, $data);
    }

    public function destroy(IncomeCategory $incomeCategory): RedirectResponse
    {
        if ($incomeCategory->user_id !== auth()->id()) {
            abort(403);
        }

        $incomeCategory->load('incomes');
        if ($incomeCategory->incomes->isNotEmpty()) {
            $incomeCategory->incomes()->update([
                'category_id' => 1
            ]);
        }

        $incomeCategory->delete();
        return redirect()->route($this->indexRoute);
    }
}
