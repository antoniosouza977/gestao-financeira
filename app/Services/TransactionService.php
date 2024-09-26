<?php

namespace App\Services;

use App\Models\Transaction;
use App\Services\QueryBuilders\Transactions\TransactionBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{

    private TransactionBuilder $transactionBuilder;

    public function __construct(TransactionBuilder $transactionBuilder)
    {
        $this->transactionBuilder = $transactionBuilder;
    }

    public function paginatedUserTransactions(string $type, array $filters): Collection|LengthAwarePaginator
    {
        $filters['type'] = $type;

        return $this->transactionBuilder->doQuery($filters);
    }

    public function getMonthlyTransactions(int $type): Collection
    {
        return Transaction::query()
            ->where('type', $type)
            ->where('user_id', auth()->id())
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->get();
    }

    public function getLatestTransactions(int $type, int $count = 5): Collection
    {
        return Transaction::query()
            ->with(['category'])
            ->where('type', $type)
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->limit($count)
            ->get();
    }

    public function currentMonthTotal($type): float
    {
        $total = $this->getMonthlyTransactions($type)->sum('value');

        return round($total, 2);
    }

}
