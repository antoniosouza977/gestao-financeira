<?php

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
    public const INCOME  = 1;
    public const EXPENSE = 2;

    //Status
    public const PENDING  = 0;
    public const DONE = 1;

    // Period Types
    public const DAILY       = 1;
    public const WEEKLY      = 2;
    public const MONTHLY     = 3;
    public const ANNUALLY    = 4;
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
        'category_id'
    ];

    protected $casts = [
        'value'       => 'encrypted',
        'description' => 'encrypted',
        'active'      => 'boolean',
    ];

    protected $with = ['category'];

    protected $appends = ['period_value_label'];

    public function getPeriodValueLabelAttribute()
    {
        switch ($this['period_type']) {
            case self::DAILY;
            return 'Todos os dias';
            case self::WEEKLY;
            return WeekDays::$labels[$this['period_value']];
            case self::MONTHLY;
            return "Dia $this[period_value]";
            case self::ANNUALLY;
            return Months::$labels[$this['period_value']];
            case self::INSTALLMENT;
            return "$this[period_value] parcelas";
        }
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
