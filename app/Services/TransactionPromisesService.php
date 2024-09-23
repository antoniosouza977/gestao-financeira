<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionPromise;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TransactionPromisesService
{

    public function missingConfirmation(string $type): Collection
    {
        $promises = TransactionPromise::query()
            ->where('user_id', auth()->id())
            ->where('type', $type)
            ->where('active', true)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('period_type', TransactionPromise::DAILY);
                    $query->whereDoesntHave('transactions', function ($query) {
                        $query->whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
                    });
                });
                $query->orWhere(function ($query) {
                    $query->where('period_type', TransactionPromise::WEEKLY);
                    $query->where('period_value', '<=', (Carbon::now()->dayOfWeek() + 1));
                    $query->whereDoesntHave('transactions', function ($query) {
                        $query->whereBetween('date', [Carbon::now()->startOfWeek(CarbonInterface::SUNDAY), Carbon::now()->endOfWeek()]);
                    });
                });
                $query->orWhere(function ($query) {
                    $query->where('period_type', TransactionPromise::MONTHLY);
                    $query->where('period_value', '<=', (Carbon::now()->day));
                    $query->whereDoesntHave('transactions', function ($query) {
                        $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    });
                });
                $query->orWhere(function ($query) {
                    $query->where('period_type', TransactionPromise::ANNUALLY);
                    $query->where('period_value', '<=', Carbon::now()->month);
                    $query->whereDoesntHave('transactions', function ($query) {
                        $query->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                    });
                });
                $query->orWhere(function ($query) {
                    $query->where('period_type', TransactionPromise::INSTALLMENT);
                    $query->where('status', TransactionPromise::PENDING);
                    $query->whereDoesntHave('transactions', function ($query) {
                        $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    });
                });
            })
            ->get();

        return $promises->map(function (TransactionPromise $promise) {

            switch ($promise->period_type) {
                case TransactionPromise::DAILY:
                    $promise->date = Carbon::now()->format('Y-m-d');
                    return $promise;
                case TransactionPromise::WEEKLY:
                    $promise->date = Carbon::now()->startOfWeek(CarbonInterface::SUNDAY)->addDays((int)($promise->period_value - 1))->format('Y-m-d');
                    return $promise;
                case TransactionPromise::MONTHLY:
                    $promise->date = Carbon::now()->startOfMonth()->addDays((int)$promise->period_value - 1)->format('Y-m-d');
                    return $promise;
                case TransactionPromise::ANNUALLY:
                    $promise->date = Carbon::now()
                        ->startOfYear()
                        ->addMonths((int)$promise->period_value - 1)
                        ->format('Y-m-d');
                    return $promise;
                case TransactionPromise::INSTALLMENT:
                    $promise->date = Carbon::now()->startOfMonth()->format('Y-m-d');
                    return $promise;
            }

            return $promise;
        });
    }

    public function paginatedUserTransactions(string $type): LengthAwarePaginator
    {
        return Transaction::query()
            ->where('user_id', auth()->id())
            ->where('type', $type)
            ->paginate(10);
    }

    public function currentMonthTotal(int $type): Collection
    {
        return TransactionPromise::query()
            ->where('user_id', auth()->id())
            ->where('type', $type)
            ->where('active', true)
            ->where('status', TransactionPromise::PENDING)
            ->get();
    }

    public function totalCurrentMonthPromises(int $type): float
    {
        $total = $this->currentMonthTotal($type)->sum('value');

        return round($total, 2);
    }

}
