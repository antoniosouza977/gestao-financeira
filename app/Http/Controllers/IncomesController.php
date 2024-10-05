<?php

namespace App\Http\Controllers;

use App\Models\TransactionPromise;

class IncomesController extends TransactionsController
{
    protected string $indexRoute = 'incomes.index';
    protected int $type = TransactionPromise::INCOME;
    protected string $indexComponent = 'Incomes/Index';
}
