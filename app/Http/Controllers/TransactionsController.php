<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionPromise;
use App\Services\TransactionPromisesService;
use App\Validators\BaseValidator;
use App\Validators\TransactionValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

abstract class TransactionsController extends Controller
{

    protected TransactionPromisesService $promisesService;
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected int $type;
    protected string $indexComponent;

    public function __construct(TransactionPromisesService $transactionsService, TransactionValidator $validator, SaveModelAction $saveModelAction)
    {
        $this->promisesService = $transactionsService;
        $this->validator = $validator;
        $this->saveModelAction = $saveModelAction;
    }

    public function index(): Response
    {
        $promisesMissingConfirmation = $this->promisesService->missingConfirmation($this->type);
        $transactions = $this->promisesService->paginatedUserTransactions($this->type);
        $categories = Category::query()
            ->where('user_id', auth()->id())
            ->where('type', $this->type)
            ->get();
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
