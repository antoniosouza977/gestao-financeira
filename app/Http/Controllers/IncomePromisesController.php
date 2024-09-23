<?php

namespace App\Http\Controllers;

use App\Actions\Database\SaveModelAction;
use App\Models\TransactionPromise;
use App\Validators\BaseValidator;

class IncomePromisesController extends TransactionPromisesController
{
    protected SaveModelAction $saveModelAction;
    protected BaseValidator $validator;
    protected string $indexRoute = 'income-promises.index';
    protected string $componentPath = 'IncomePromises';
    protected int $type = TransactionPromise::INCOME;

}
