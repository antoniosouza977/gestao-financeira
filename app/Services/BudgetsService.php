<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

class BudgetsService
{
    private ?Authenticatable $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }


    public function monthlyBudgets(array $columns = ['*']): Collection
    {
        return $this->user->budgets()
            ->get($columns);
    }

    public function monthlyBudgetsTotal(): string
    {
        $budgets = $this->monthlyBudgets(['value']);
        $total = $budgets->sum('value');

        return round($total, 2);
    }

}
