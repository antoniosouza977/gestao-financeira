<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class IncomeCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $casts = [
        'name' => 'encrypted',
    ];

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class, 'category_id', 'id');
    }

}
