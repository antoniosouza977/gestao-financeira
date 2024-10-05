<?php

namespace App\Http\Controllers;

use App\Models\TransactionPromise;

class ExpensesController extends TransactionsController
{
    protected string $indexRoute = 'expenses.index';
    protected int $type = TransactionPromise::EXPENSE;
    protected string $indexComponent = 'Expenses/Index';
}
