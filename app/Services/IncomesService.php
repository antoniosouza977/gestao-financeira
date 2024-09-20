<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;

class IncomesService
{
    private Authenticatable $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function monthlyIncomes(array $columns = ['*'])
    {
        return $this->user
            ->incomes()
            ->get($columns);
    }

    public function monthlyIncomesTotal(): string
    {
        $incomes = $this->monthlyIncomes(['value']);
        $total = $incomes->sum('value');

        return round($total, 2);
    }

}
