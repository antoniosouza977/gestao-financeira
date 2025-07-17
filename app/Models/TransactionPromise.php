<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Months;
use App\Enums\WeekDays;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionPromise extends Model
{
    use HasFactory;

    // Types
    public const INCOME = 1;

    public const EXPENSE = 2;

    // Status
    public const PENDING = 0;

    public const DONE = 1;

    // Period Types
    public const DAILY = 1;

    public const WEEKLY = 2;

    public const MONTHLY = 3;

    public const ANNUALLY = 4;

    public const INSTALLMENT = 5;

    public $timestamps = false;

    protected $fillable = [
        'value',
        'description',
        'type',
        'period_type',
        'period_value',
        'last_confirmation',
        'active',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'value' => 'encrypted',
        'description' => 'encrypted',
        'active' => 'boolean',
    ];

    protected $with = ['category'];

    protected $appends = ['period_value_label'];

    public function getPeriodValueLabelAttribute()
    {
        return match ($this['period_type']) {
            self::DAILY => 'Todos os dias',
            self::WEEKLY => WeekDays::$labels[$this['period_value']],
            self::MONTHLY => "Dia $this[period_value]",
            self::ANNUALLY => Months::$labels[$this['period_value']],
            self::INSTALLMENT => "$this[period_value] parcelas",
            default => null,
        };

    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
