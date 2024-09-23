<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\TransactionPromisesService;
use App\Services\TransactionService;
use Carbon\Carbon;
use Inertia\Response;

class DashboardController extends Controller
{
    private TransactionService $transactionService;
    private TransactionPromisesService $transactionPromisesService;

    public function __construct(TransactionService $transactionService, TransactionPromisesService $transactionPromisesService)
    {
        $this->transactionService = $transactionService;
        $this->transactionPromisesService = $transactionPromisesService;
    }

    public function index(): Response
    {
        $startPeriod = Carbon::now()->startOfMonth()->format('d/m');
        $endPeriod = Carbon::now()->endOfMonth()->format('d/m');

        $incomesTotal = $this->transactionService->currentMonthTotal(Transaction::INCOME);
        $expensesTotal = $this->transactionService->currentMonthTotal(Transaction::EXPENSE);

        $incomePromisesTotal = $this->transactionPromisesService->totalCurrentMonthPromises(Transaction::INCOME);
        $expensePromisesTotal = $this->transactionPromisesService->totalCurrentMonthPromises(Transaction::EXPENSE);

        $latestsExpenses = $this->transactionService->getLatestTransactions(Transaction::EXPENSE);
        $categories = Category::query()
            ->where('user_id', auth()->id())
            ->where('type', Category::EXPENSE)
            ->get();

        return inertia()->render('Dashboard', compact('incomesTotal', 'expensesTotal', 'incomePromisesTotal', 'expensePromisesTotal', 'latestsExpenses', 'startPeriod', 'endPeriod', 'categories'));
    }
}
