<?php

namespace App\Services;

use App\Models\Income;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

class PaymentsService
{
    private User $user;

    public function __construct()
    {
        $this->user = User::query()->find(auth()->id());
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
        return $this->user->payments()->paginate(5);
    }

}
