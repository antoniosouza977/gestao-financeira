<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Enums\ValidationType;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Validators\IncomeValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class IncomesController extends Controller
{
    private SaveModelAction $saveModelAction;
    private IncomeValidator $validator;

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
        $incomes = Auth::user()->incomes;

        return Inertia::render('Incomes/IncomesIndex', compact('incomes'));
    }

    public function create(): Response
    {
        $categories = IncomeCategory::query()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', null)
            ->get();

        return Inertia::render('Incomes/IncomesForm', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $request->only(['value', 'category_id', 'payment_day', 'description']);
            $data['user_id'] = auth()->id();

            $this->saveModelAction
                ->setModel(new Income())
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData(ValidationType::CREATE)
                ->execute();

            return Redirect::route('incomes.index');
        } catch (ValidationException $e) {
            return Redirect::back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function edit(Income $income): Response
    {
        $categories = IncomeCategory::query()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', null)
            ->get();

        return Inertia::render('Incomes/IncomesForm', compact('income', 'categories'));
    }


    public function update(Request $request, Income $income): RedirectResponse
    {
        try {

            if ($income->user_id !== auth()->id()) {
                throw ValidationException::withMessages([
                    'user_id' => 'Incorrect user',
                ]);
            }

            $data = $request->only(['value', 'category_id', 'payment_day', 'description']);

            $this->saveModelAction
                ->setModel($income)
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData(ValidationType::UPDATE)
                ->execute();

            return Redirect::route('incomes.index');
        } catch (ValidationException $e) {
            return Redirect::back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }


    public function destroy(Income $income): RedirectResponse
    {
        if ($income->user_id !== auth()->id()) {
            return Redirect::route('incomes.index');
        }

        $income->delete();

        return Redirect::route('incomes.index');
    }
}
