<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Transaction;
use App\Services\CategoriesService;
use App\Services\TransactionPromisesService;
use App\Services\TransactionsService;
use App\Validators\BaseValidator;
use App\Validators\TransactionValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

abstract class TransactionsController extends Controller
{

    protected TransactionPromisesService $promisesService;
    protected TransactionsService $transactionService;
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected CategoriesService $categoriesService;
    protected int $type;
    protected string $indexComponent;

    public function __construct
    (
        TransactionPromisesService $transactionsService,
        TransactionsService        $transactionService,
        TransactionValidator       $validator,
        SaveModelAction            $saveModelAction,
        CategoriesService          $categoriesService,
    )
    {
        $this->promisesService = $transactionsService;
        $this->transactionService = $transactionService;
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
        $this->categoriesService = $categoriesService;
    }

    public function index(Request $request): Response
    {
        $promisesMissingConfirmation = $this->promisesService->missingConfirmation($this->type);
        $transactions = $this->transactionService->paginatedUserTransactions($this->type, $request->all());
        $categories = $this->categoriesService->getAll($this->type);
        $type = $this->type;

        return inertia()->render($this->indexComponent, compact('promisesMissingConfirmation', 'transactions', 'categories', 'type'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'description', 'date', 'category_id', 'transaction_promise_id']);
        $data['type'] = $this->type;
        return $this->baseStore(new Transaction(), $data);
    }


    public function update(Transaction $transaction, Request $request): RedirectResponse
    {
        $data = $request->only(['value', 'description', 'date', 'category_id']);
        return $this->baseUpdate($transaction, $data);
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route($this->indexRoute);
    }


}
