<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TransactionPromise;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;

class TransactionPromisesService
{
    public function missingConfirmation(int $type): Collection
    {
        $promises = TransactionPromise::query()
            ->where('user_id', auth()->id())
            ->where('type', $type)
            ->where('active', true)
            ->where(function ($query): void {
                $query->where(function ($query): void {
                    $query->where('period_type', TransactionPromise::DAILY);
                    $query->whereDoesntHave('transactions', function ($query): void {
                        $query->whereBetween('date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
                    });
                });
                $query->orWhere(function ($query): void {
                    $query->where('period_type', TransactionPromise::WEEKLY);
                    $query->where('period_value', '<=', (Carbon::now()->dayOfWeek() + 1));
                    $query->whereDoesntHave('transactions', function ($query): void {
                        $query->whereBetween('date', [Carbon::now()->startOfWeek(CarbonInterface::SUNDAY), Carbon::now()->endOfWeek()]);
                    });
                });
                $query->orWhere(function ($query): void {
                    $query->where('period_type', TransactionPromise::MONTHLY);
                    $query->where('period_value', '<=', (Carbon::now()->day));
                    $query->whereDoesntHave('transactions', function ($query): void {
                        $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    });
                });
                $query->orWhere(function ($query): void {
                    $query->where('period_type', TransactionPromise::ANNUALLY);
                    $query->where('period_value', '<=', Carbon::now()->month);
                    $query->whereDoesntHave('transactions', function ($query): void {
                        $query->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                    });
                });
                $query->orWhere(function ($query): void {
                    $query->where('period_type', TransactionPromise::INSTALLMENT);
                    $query->where('status', TransactionPromise::PENDING);
                    $query->whereDoesntHave('transactions', function ($query): void {
                        $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    });
                });
            })
            ->get();

        return $promises->map(function (TransactionPromise $transactionPromise): \App\Models\TransactionPromise {

            switch ($transactionPromise->period_type) {
                case TransactionPromise::DAILY:
                    $transactionPromise->date = Carbon::now()->format('Y-m-d');

                    return $transactionPromise;
                case TransactionPromise::WEEKLY:
                    $transactionPromise->date = Carbon::now()->startOfWeek(CarbonInterface::SUNDAY)->addDays((int) ($transactionPromise->period_value - 1))->format('Y-m-d');

                    return $transactionPromise;
                case TransactionPromise::MONTHLY:
                    $transactionPromise->date = Carbon::now()->startOfMonth()->addDays((int) $transactionPromise->period_value - 1)->format('Y-m-d');

                    return $transactionPromise;
                case TransactionPromise::ANNUALLY:
                    $transactionPromise->date = Carbon::now()
                        ->startOfYear()
                        ->addMonths((int) $transactionPromise->period_value - 1)
                        ->format('Y-m-d');

                    return $transactionPromise;
                case TransactionPromise::INSTALLMENT:
                    $transactionPromise->date = Carbon::now()->startOfMonth()->format('Y-m-d');

                    return $transactionPromise;
            }

            return $transactionPromise;
        });
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
