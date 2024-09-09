<?php

namespace App\Http\Controllers;

use App\Actions\Database\QueryModelByID;
use App\Actions\Database\SaveModelAction;
use App\Enums\ValidationType;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Validators\IncomeValidator;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class IncomesController extends Controller
{
    private SaveModelAction $saveModelAction;
    private QueryModelByID $queryModelByID;
    private IncomeValidator $validator;

    public function __construct
    (
        IncomeValidator       $validator,
        SaveModelAction       $saveModelAction,
        QueryModelByID       $queryModelByID
    )
    {
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
        $this->queryModelByID = $queryModelByID;
    }

    public function index(): Response
    {
        $incomes = auth()->user()->incomes;
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
            $data = $request->only(['amount', 'category_id', 'date', 'description', 'monthly_income']);
            $data['user_id'] = auth()->id();
            $data['date'] = Carbon::make($data['date'])?->format('Y-m-d');
            $data = array_filter($data);

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

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $income = $this->repository->find($id);
//
//        if (request()->wantsJson()) {
//
//            return response()->json([
//                'data' => $income,
//            ]);
//        }
//
//        return view('incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
//    public function edit($id)
//    {
//        $income = $this->repository->find($id);
//
//        return view('incomes.edit', compact('income'));
//    }


    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $income = $this->queryModelByID->setModel(new Income())->setId($id)->execute();

            $data = $request->only(['amount', 'category_id', 'date', 'description', 'monthly_income']);
            $data['date'] = Carbon::make($data['date'])?->format('Y-m-d');
            $data = array_filter($data);

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


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        $deleted = $this->repository->delete($id);
//
//        if (request()->wantsJson()) {
//
//            return response()->json([
//                'message' => 'Income deleted.',
//                'deleted' => $deleted,
//            ]);
//        }
//
//        return redirect()->back()->with('message', 'Income deleted.');
//    }
}
