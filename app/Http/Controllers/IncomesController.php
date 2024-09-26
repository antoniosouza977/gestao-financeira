<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\TransactionPromise;
use App\Services\TransactionPromisesService;
use App\Services\TransactionService;
use App\Validators\BaseValidator;
use App\Validators\TransactionValidator;

class IncomesController extends TransactionsController
{

    protected TransactionPromisesService $promisesService;
    protected BaseValidator $validator;
    protected SaveModelAction $saveModelAction;
    protected string $indexRoute = 'incomes.index';
    protected int $type = TransactionPromise::INCOME;
    protected string $indexComponent = 'Incomes/Index';


    public function __construct
    (
        TransactionPromisesService $paymentsService,
        TransactionService         $transactionService,
        TransactionValidator       $validator,
        SaveModelAction            $saveModelAction
    )
    {
        parent::__construct($paymentsService, $validator, $saveModelAction, $transactionService);
    }


}
