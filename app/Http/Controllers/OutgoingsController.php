<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Outgo;
use App\Services\OutgoingsService;
use App\Validators\BaseValidator;
use App\Validators\OutgoValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class OutgoingsController extends Controller
{

    protected OutgoingsService $outgoingsService;
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'outgoings.index';

    public function __construct(OutgoingsService $outgoingsService, OutgoValidator $validator, SaveModelAction $saveModelAction)
    {
        $this->outgoingsService = $outgoingsService;
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function index(): Response
    {
        $expensesWithNoOutgo = $this->outgoingsService->missingExpenseOutgoings();
        $outgoings = $this->outgoingsService->userOutgoings();

        return inertia()->render('Outgoings/Index', compact('expensesWithNoOutgo', 'outgoings'));
    }

    public function create(): Response
    {
        $budgets = auth()->user()->budgets;

        return inertia()->render('Outgoings/Form', compact('budgets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'description', 'date', 'expense_id', 'budget_id']);
        return $this->baseStore(new Outgo(), $data);
    }

    public function show(int $id): Response
    {
        $outgo = Outgo::query()->find($id);
        return $this->edit($outgo);
    }

    public function edit(int $id): Response
    {
        $outgo = Outgo::query()->find($id);
        $budgets = auth()->user()->budgets;

        return inertia()->render('Outgoings/Form', compact('outgo', 'budgets'));
    }

    public function update(int $id, Request $request): RedirectResponse
    {
        $outgo = Outgo::query()->find($id);
        $data = $request->only(['value', 'description', 'date', 'expense_id', 'budget_id']);
        return $this->baseUpdate($outgo, $data);
    }

    public function destroy(int $id): RedirectResponse
    {
        $outgo = Outgo::query()->find($id);

        if ($outgo->user_id !== auth()->id()) {
            abort(403);
        }

        $outgo->load('expense');
        $expense = $outgo->expense;

        $outgo->delete();

        if (!$expense?->active && $expense?->outgoings->count() === 0) {
            $expense->delete();
        }

        return redirect()->route($this->indexRoute);
    }


}
