<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outgo extends Model
{
    use HasFactory;

    protected $table = 'outgoings';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'budget_id',
        'expense_id',
        'value',
        'description',
        'date',
    ];

    protected $with = ['expense', 'budget'];

    protected $casts = [
        'value'       => 'encrypted',
        'description' => 'encrypted',
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
