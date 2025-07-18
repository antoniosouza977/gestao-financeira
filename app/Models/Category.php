<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public const INCOME = 1;

    public const EXPENSE = 2;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'user_id',
    ];

    protected $casts = [
        'name' => 'encrypted',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionPromises(): HasMany
    {
        return $this->hasMany(TransactionPromise::class);
    }
}
