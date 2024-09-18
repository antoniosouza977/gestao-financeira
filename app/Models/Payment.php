<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'income_id',
        'value',
        'description',
        'date',
    ];

    protected $with = ['income'];

    protected $casts = [
        'value'       => 'encrypted',
        'description' => 'encrypted',
    ];

    public function income(): BelongsTo
    {
        return $this->belongsTo(Income::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
