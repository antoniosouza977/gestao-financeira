<?php

namespace App\Http\Controllers;

use App\Repositories\IncomeCategoryRepository;
use App\Repositories\IncomeRepository;
use App\Services\IncomeCategoryService;
use App\Validators\IncomeValidator;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class IncomesController.
 *
 * @package namespace App\Http\Controllers;
 */
class IncomesController extends Controller
{
    protected IncomeRepository $repository;
    protected IncomeCategoryRepository $categoryRepository;
    protected IncomeValidator $validator;

    public function __construct
    (
        IncomeRepository      $repository,
        IncomeValidator       $validator,
        IncomeCategoryRepository $categoryRepository
    )
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        $incomes = $this->repository->findByUser();
        return Inertia::render('Incomes/IncomesIndex', compact('incomes'));
    }

    public function create(): Response
    {
        $categories = $this->categoryRepository->findByUser();
        return Inertia::render('Incomes/IncomesForm', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $this->repository->filterRequest($request);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $this->repository->create($data);

            return Redirect::route('incomes.index');

        } catch (ValidatorException $e) {
            return Redirect::back()
                ->withErrors($e->getMessageBag())
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
        $income = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $income,
            ]);
        }

        return view('incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income = $this->repository->find($id);

        return view('incomes.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IncomeUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Request $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $income = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Income updated.',
                'data'    => $income->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Income deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Income deleted.');
    }
}
