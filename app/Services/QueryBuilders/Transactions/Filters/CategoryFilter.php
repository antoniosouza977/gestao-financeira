<?php

declare(strict_types=1);

namespace App\Services\QueryBuilders\Transactions\Filters;

use App\Services\QueryBuilders\Filter;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
    public function apply(Builder $builder, $value): void
    {
        if ($value) {
            $builder->where('category_id', $value);
        }
    }
}
