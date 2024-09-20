<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Budget;
use App\Models\ExpenseCategory;
use App\Validators\BaseValidator;
use App\Validators\BudgetValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class BudgetsController extends Controller
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected string $indexRoute = 'budgets.index';

    public function __construct(SaveModelAction $saveModelAction, BudgetValidator $validator)
    {
        $this->saveModelAction = $saveModelAction;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        $budgets = auth()->user()->budgets()->paginate(10);

        return inertia()->render('Budgets/Index', compact('budgets'));
    }

    public function create(): Response
    {
        $categories = ExpenseCategory::query()
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })->get();

        return inertia()->render('Budgets/Form', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['name', 'value', 'category_id']);
        return $this->baseStore(new Budget(), $data);
    }

    public function show(Budget $budget): Response
    {
        return $this->edit($budget);
    }

    public function edit(Budget $budget): Response
    {
        $categories = ExpenseCategory::query()
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })->get();

        return inertia()->render('Budgets/Form', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget): RedirectResponse
    {
        $data = $request->only(['name', 'value', 'category_id']);
        return $this->baseUpdate($budget, $data);
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        $expenses = $budget->expenses;
        if (!$expenses->isEmpty()) {
            $expenses->update([
                'budget_id' => null,
            ]);
        }

        $budget->delete();
        return redirect()->route($this->indexRoute);
    }
}
