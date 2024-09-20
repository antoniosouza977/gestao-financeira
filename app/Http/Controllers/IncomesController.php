<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Validators\BaseValidator;
use App\Validators\IncomeValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class IncomesController extends Controller
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected string $indexRoute = 'incomes.index';

    public function __construct
    (
        IncomeValidator $validator,
        SaveModelAction $saveModelAction
    )
    {
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function index(): Response
    {
        $incomes = auth()->user()->incomes()->paginate(10);

        return inertia()->render('Incomes/Index', compact('incomes'));
    }

    public function create(): Response
    {
        $categories = IncomeCategory::query()
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })->get();

        return inertia()->render('Incomes/Form', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'category_id', 'payment_day', 'description']);
        return $this->baseStore(new Income(), $data);
    }

    public function show(Income $income): Response
    {
        return $this->edit($income);
    }

    public function edit(Income $income): Response
    {
        $categories = IncomeCategory::query()
            ->where(function ($query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })->get();

        return inertia()->render('Incomes/Form', compact('income', 'categories'));
    }

    public function update(Request $request, Income $income): RedirectResponse
    {
        $data = $request->only(['value', 'category_id', 'payment_day', 'description']);
        return $this->baseUpdate($income, $data);
    }


    public function destroy(Income $income): RedirectResponse
    {
        if ($income->user_id !== auth()->id()) {
            abort(403);
        }

        if ($income->payments->count()) {
            $income->update([
                'active' => false
            ]);
            return redirect()->route($this->indexRoute);
        }

        $income->delete();
        return redirect()->route($this->indexRoute);
    }
}
