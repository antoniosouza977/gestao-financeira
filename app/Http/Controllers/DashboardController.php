<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\CategoriesService;
use App\Services\TransactionPromisesService;
use App\Services\TransactionsService;
use Carbon\Carbon;
use Inertia\Response;

class DashboardController extends Controller
{
    private TransactionsService $transactionService;
    private TransactionPromisesService $transactionPromisesService;
    private CategoriesService $categoriesService;

    public function __construct
    (
        TransactionsService $transactionService,
        TransactionPromisesService $transactionPromisesService,
        CategoriesService $categoriesService
    )
    {
        $this->transactionService = $transactionService;
        $this->transactionPromisesService = $transactionPromisesService;
        $this->categoriesService = $categoriesService;
    }

    public function index(): Response
    {
        $startPeriod = Carbon::now()->startOfMonth()->format('d/m');
        $endPeriod = Carbon::now()->endOfMonth()->format('d/m');

        $incomesTotal = $this->transactionService->currentMonthTotal(Transaction::INCOME);
        $expensesTotal = $this->transactionService->currentMonthTotal(Transaction::EXPENSE);

        $wallet = round($incomesTotal - $expensesTotal,2);
        $expensePromisesTotal = $this->transactionPromisesService->totalCurrentMonthPromises(Transaction::EXPENSE);

        $latestsExpenses = $this->transactionService->getLatestTransactions(Transaction::EXPENSE,6);
        $categories = $this->categoriesService->getAll(Category::EXPENSE);

        return inertia()->render('Dashboard', compact('incomesTotal', 'expensesTotal', 'wallet', 'expensePromisesTotal', 'latestsExpenses', 'startPeriod', 'endPeriod', 'categories'));
    }
}
