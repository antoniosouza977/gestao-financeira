<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Income extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'value',
        'user_id',
        'category_id',
        'description',
        'payment_day',
        'active'
    ];

    protected $with = [
        'category'
    ];

    protected $casts = [
        'value'       => 'encrypted',
        'description' => 'encrypted',
        'payment_day' => 'encrypted',
        'active'      => 'boolean',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(IncomeCategory::class, 'id', 'category_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

}
