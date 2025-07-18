<?php

declare(strict_types=1);

namespace App\Services\QueryBuilders\Transactions\Filters;

use App\Services\QueryBuilders\Filter;
use Illuminate\Database\Eloquent\Builder;

class PeriodEndFilter implements Filter
{
    public function apply(Builder $builder, $value): void
    {
        $builder->where('date', '<=', $value);
    }
}
