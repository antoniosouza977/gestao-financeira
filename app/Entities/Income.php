<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Income.
 *
 * @package namespace App\Entities;
 */
class Income extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'user_id',
        'amount',
        'category_id',
        'date',
        'description',
        'monthly_income'
    ];

    protected $with = [
        'category'
    ];

    public function category(): HasOne
    {
        return $this->hasOne(IncomeCategory::class, 'id', 'category_id');
    }

}
