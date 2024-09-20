<?php

namespace App\Services;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PaymentsService
{
    private ?Authenticatable $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function missingIncomePayments(): Collection
    {
        $incomes = $this->user
            ->incomes()
            ->whereDoesntHave('payments', function ($query) {
                $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            })
            ->get();

        return $incomes->map(function (Income $income) {
            $income->date = date('Y-m') . '-' . str_pad($income->payment_day, '2', '0', STR_PAD_LEFT);
            return $income;
        });
    }

    public function userPayments(): LengthAwarePaginator
    {
        return $this->user->payments()->paginate(10);
    }

    public function monthlyPayments(array $columns = ['*']): Collection
    {
        return $this->user->payments()
            ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get($columns);
    }

    public function monthlyPaymentsTotal(): string
    {
        $payments = $this->monthlyPayments(['value']);
        $sum = $payments->sum('value');

        return round($sum, 2);
    }

}
