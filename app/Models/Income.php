<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Income extends Model
{
    protected $fillable = [
        'amount',
        'user_id',
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
