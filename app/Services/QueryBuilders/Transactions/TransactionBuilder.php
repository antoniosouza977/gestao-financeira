<?php

namespace App\Services\QueryBuilders\Transactions;

use App\Models\Transaction;
use App\Services\QueryBuilders\Builder;
use App\Services\QueryBuilders\Filter;
use App\Services\QueryBuilders\Transactions\Filters\CategoryFilter;
use App\Services\QueryBuilders\Transactions\Filters\PeriodEndFilter;
use App\Services\QueryBuilders\Transactions\Filters\PeriodStartFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TransactionBuilder implements Builder
{

    public function doQuery(array $filters, bool $paginate = true): Collection|LengthAwarePaginator
    {
        $builder = Transaction::query()
            ->where('user_id', auth()->id())
            ->where('type', $filters['type'])
            ->orderBy('date', 'desc');

        $transactionFilters = $this->filterList();

        foreach ($filters as $field => $value) {
            if (key_exists($field, $transactionFilters) && $value !== null) {
                /** @var Filter $filter */
                $filter = app($transactionFilters[$field]);
                $filter->apply($builder, $value);
            }
        }

        if ($paginate) {
            return $builder->paginate(10);
        }

        return $builder->get();
    }

    private function filterList(): array
    {
        return [
            'start_date'  => PeriodStartFilter::class,
            'end_date'    => PeriodEndFilter::class,
            'category_id' => CategoryFilter::class
        ];
    }
}
