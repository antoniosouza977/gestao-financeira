<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'user_id',
        'category_id',
        'description',
        'monthly_payment',
        'payment_day'
    ];

    protected $with = [
        'category'
    ];

    protected $casts = [
        'amount' => 'float',
        'monthly_payment' => 'boolean'
    ];

    public function category(): HasOne
    {
        return $this->hasOne(IncomeCategory::class, 'id', 'category_id');
    }

}
