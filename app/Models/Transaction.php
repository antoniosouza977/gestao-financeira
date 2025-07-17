<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public const INCOME = 1;

    public const EXPENSE = 2;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'category_id',
        'transaction_promise_id',
        'value',
        'type',
        'description',
        'date',
    ];

    protected $with = ['category', 'promise'];

    protected $casts = [
        'value' => 'encrypted',
        'description' => 'encrypted',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function promise(): BelongsTo
    {
        return $this->belongsTo(TransactionPromise::class, 'transaction_promise_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
