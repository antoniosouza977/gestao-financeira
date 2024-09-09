<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

/**
 * Class IncomeValidator.
 *
 * @package namespace App\Validators;
 */
class IncomeValidator extends BaseValidator
{
    protected $attributes = [
        'amount'      => 'valor',
        'category_id' => 'categoria',
    ];

    public function updateRules(): array
    {
        return [];
    }

    public function createRules(): array
    {
        return [
            'user_id'        => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')
                    ->where('id', auth()->id())
            ],
            'amount'         => 'required|numeric',
            'category_id'    => 'required|exists:income_categories,id',
            'date'           => 'required|date',
            'description'    => 'string',
            'monthly_income' => 'boolean',
        ];
    }
}
