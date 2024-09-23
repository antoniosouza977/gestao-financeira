<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\TransactionPromise;
use App\Services\TransactionPromisesService;
use App\Validators\BaseValidator;
use App\Validators\TransactionValidator;

class ExpensesController extends TransactionsController
{

    protected TransactionPromisesService $promisesService;
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'expenses.index';
    protected int $type = TransactionPromise::EXPENSE;
    protected string $indexComponent = 'Expenses/Index';


    public function __construct(TransactionPromisesService $paymentsService, TransactionValidator $validator, SaveModelAction $saveModelAction)
    {
        parent::__construct($paymentsService, $validator, $saveModelAction);
    }


}
