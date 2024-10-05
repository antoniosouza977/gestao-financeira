<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\TransactionPromise;
use App\Validators\BaseValidator;

class ExpensePromisesController extends TransactionPromisesController
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected string $indexRoute = 'expense-promises.index';
    protected string $componentPath = 'ExpensePromises';
    protected int $type = TransactionPromise::EXPENSE;
}
