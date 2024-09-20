<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Expense;
use App\Validators\BaseValidator;
use App\Validators\ExpenseValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ExpensesController extends Controller
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected string $indexRoute = 'expenses.index';

    public function __construct
    (
        ExpenseValidator $validator,
        SaveModelAction  $saveModelAction
    )
    {
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function index(): Response
    {
        $expenses = auth()->user()->expenses()->paginate(10);

        return inertia()->render('Expenses/Index', compact('expenses'));
    }

    public function create(): Response
    {
        $budgets = auth()->user()->budgets;

        return inertia()->render('Expenses/Form', compact('budgets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'budget_id', 'payment_day', 'description']);
        return $this->baseStore(new Expense(), $data);
    }

    public function show(Expense $expense): Response
    {
        return $this->edit($expense);
    }

    public function edit(Expense $expense): Response
    {
        $budgets = auth()->user()->budgets;

        return inertia()->render('Expenses/Form', compact('expense', 'budgets'));
    }


    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $data = $request->only(['value', 'budget_id', 'payment_day', 'description']);
        return $this->baseUpdate($expense, $data);
    }


    public function destroy(Expense $expense): RedirectResponse
    {
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        if ($expense->outgoings->count()) {
            $expense->update([
                'active' => false
            ]);
            return redirect()->route($this->indexRoute);
        }

        $expense->delete();
        return redirect()->route($this->indexRoute);
    }
}
