<?php

declare(strict_types=1);

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
    private TransactionsService $transactionsService;

    private TransactionPromisesService $transactionPromisesService;

    private CategoriesService $categoriesService;

    public function __construct(
        TransactionsService $transactionsService,
        TransactionPromisesService $transactionPromisesService,
        CategoriesService $categoriesService
    ) {
        $this->transactionsService = $transactionsService;
        $this->transactionPromisesService = $transactionPromisesService;
        $this->categoriesService = $categoriesService;
    }

    public function index(): Response
    {
        $startPeriod = Carbon::now()->startOfMonth()->format('d/m');
        $endPeriod = Carbon::now()->endOfMonth()->format('d/m');

        $incomesTotal = $this->transactionsService->currentMonthTotal(Transaction::INCOME);
        $expensesTotal = $this->transactionsService->currentMonthTotal(Transaction::EXPENSE);

        $wallet = round($incomesTotal - $expensesTotal, 2);
        $expensePromisesTotal = $this->transactionPromisesService->totalCurrentMonthPromises(Transaction::EXPENSE);

        $latestsExpenses = $this->transactionsService->getLatestTransactions(Transaction::EXPENSE, 6);
        $categories = $this->categoriesService->getAll(Category::EXPENSE);

        return inertia()->render('Dashboard', ['incomesTotal' => $incomesTotal, 'expensesTotal' => $expensesTotal, 'wallet' => $wallet, 'expensePromisesTotal' => $expensePromisesTotal, 'latestsExpenses' => $latestsExpenses, 'startPeriod' => $startPeriod, 'endPeriod' => $endPeriod, 'categories' => $categories]);
    }
}
