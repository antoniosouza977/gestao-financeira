<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoriesService
{
    private TransactionsService $transactionsService;

    public function __construct(TransactionsService $transactionsService)
    {
        $this->transactionsService = $transactionsService;
    }

    private function builder($type): Builder
    {
        return Category::query()
            ->where('user_id', auth()->id())
            ->where('type', $type);
    }

    public function getAll(string $type): Collection
    {
        return $this->builder($type)->get();
    }

    public function getExcept(int $id, string $type): Collection
    {
        return $this->builder($type)->where('id', '!=', $id)->get();
    }

    public function getAllWithDetails(string $type): LengthAwarePaginator
    {
        $list = $this->builder($type)
            ->paginate(10);

        foreach ($list as $item) {
            $monthTransactions = $this->transactionsService
                ->getMonthlyTransactionsBuilder($type)
                ->where('category_id', $item->id)
                ->get('value');
            $item->monthTransactionsTotal = round($monthTransactions->sum('value'), 2);
            $item->monthTransactionsCount = $monthTransactions->count();
            $item->monthTransactionsAverage = round($monthTransactions->avg('value'), 2);
        }

        return $list;
    }
}
