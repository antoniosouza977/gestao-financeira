<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'budget_id',
        'value',
        'description',
        'payment_day',
        'active',
    ];

    protected $with = ['budget'];

    protected $casts = [
        'value'       => 'encrypted',
        'description' => 'encrypted',
        'payment_day' => 'encrypted',
        'active'      => 'boolean',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function outgoings(): HasMany
    {
        return $this->hasMany(Outgo::class);
    }

}
