<?php

namespace App\Services;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OutgoingsService
{
    private ?Authenticatable $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function missingExpenseOutgoings(): Collection
    {
        $expenses = $this->user
            ->expenses()
            ->whereDoesntHave('outgoings', function ($query) {
                $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            })
            ->get();

        return $expenses->map(function (Expense $income) {
            $income->date = date('Y-m') . '-' . str_pad($income->payment_day, '2', '0', STR_PAD_LEFT);
            return $income;
        });
    }

    public function userOutgoings(): LengthAwarePaginator
    {
        return $this->user->outgoings()->paginate(10);
    }

    public function monthlyOutgoings(array $columns = ['*']): Collection
    {
        return $this->user->outgoings()
            ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->get($columns);
    }

    public function monthlyOutgoingsTotal(): string
    {
        $outgoings = $this->monthlyOutgoings(['value']);
        $total = $outgoings->sum('value');

        return round($total, 2);
    }

    public function latestsOutgoings()
    {
        return $this->user->outgoings()
            ->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
    }

}
