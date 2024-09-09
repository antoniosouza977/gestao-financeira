<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\IncomeCategoryCreateRequest;
use App\Http\Requests\IncomeCategoryUpdateRequest;
use App\Repositories\IncomeCategoryRepository;
use App\Validators\IncomeCategoryValidator;

/**
 * Class IncomeCategoriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class IncomeCategoriesController extends Controller
{
    /**
     * @var IncomeCategoryRepository
     */
    protected $repository;

    /**
     * @var IncomeCategoryValidator
     */
    protected $validator;

    /**
     * IncomeCategoriesController constructor.
     *
     * @param IncomeCategoryRepository $repository
     * @param IncomeCategoryValidator $validator
     */
    public function __construct(IncomeCategoryRepository $repository, IncomeCategoryValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $amountCategories = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $amountCategories,
            ]);
        }

        return view('amountCategories.index', compact('amountCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IncomeCategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(IncomeCategoryCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $amountCategory = $this->repository->create($request->all());

            $response = [
                'message' => 'IncomeCategoryService created.',
                'data'    => $amountCategory->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amountCategory = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $amountCategory,
            ]);
        }

        return view('amountCategories.show', compact('amountCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $amountCategory = $this->repository->find($id);

        return view('amountCategories.edit', compact('amountCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IncomeCategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(IncomeCategoryUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $amountCategory = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'IncomeCategoryService updated.',
                'data'    => $amountCategory->toArray(),
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'IncomeCategoryService deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'IncomeCategoryService deleted.');
    }
}
