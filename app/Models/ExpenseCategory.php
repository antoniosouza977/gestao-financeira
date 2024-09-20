<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    public const DEFAULT_ID = 1;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $casts = [
        'name' => 'encrypted',
    ];
}
