<?php

namespace App\Services\QueryBuilders\Transactions\Filters;

use App\Services\QueryBuilders\Filter;
use Illuminate\Database\Eloquent\Builder;

class PeriodStartFilter implements Filter
{
    public function apply(Builder $builder, $value): void
    {
        $builder->where('date', '>=', $value);
    }
}
