<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Enums\ValidationType;
use App\Models\IncomeCategory;
use App\Validators\IncomeCategoryValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class IncomeCategoriesController extends Controller
{
    private IncomeCategoryValidator $validator;
    private SaveModelAction $saveModelAction;

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
            ->where('user_id', auth()->id())
            ->orWhere('user_id', null)
            ->get();

        return Inertia::render('IncomeCategories/Index', compact('categories'));
    }

    public function create(): Response
    {
        return Inertia::render('IncomeCategories/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $request->only(['name']);
            $data['user_id'] = auth()->id();

            $this->saveModelAction->setModel(new IncomeCategory())
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData(ValidationType::CREATE)
                ->execute();

            return Redirect::route('income-categories.index');

        } catch (ValidationException $exception) {
            return Redirect::back()
                ->withErrors($exception->errors())
                ->withInput();
        }
    }

    public function edit(IncomeCategory $incomeCategory): Response
    {
        return Inertia::render('IncomeCategories/Form', ['category' => $incomeCategory]);
    }

    public function update(IncomeCategory $incomeCategory, Request $request): RedirectResponse
    {
        try {
            if ($incomeCategory->user_id !== auth()->id()) {
                return Redirect::back();
            }

            $data = $request->only(['name']);

            $this->saveModelAction
                ->setModel($incomeCategory)
                ->setData($data)
                ->setValidator($this->validator)
                ->validateData(ValidationType::UPDATE)
                ->execute();

            return Redirect::route('income-categories.index');

        } catch (ValidationException $e) {
            return Redirect::back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy(IncomeCategory $incomeCategory): RedirectResponse
    {
        if ($incomeCategory->user_id !== auth()->id()) {
            return Redirect::back();
        }

        $incomeCategory->load('incomes');
        if ($incomeCategory->incomes->isNotEmpty()) {
            $incomeCategory->incomes()->update([
                'category_id' => 1 // salario
            ]);
        }

        $incomeCategory->delete();

        return Redirect::route('income-categories.index');
    }
}
