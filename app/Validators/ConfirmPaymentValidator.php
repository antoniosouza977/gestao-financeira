<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class ConfirmPaymentValidator extends BaseValidator
{
    public function attributes(): array
    {
        return [
            'value'       => 'valor',
            'category_id' => 'categoria',
            'description' => 'descrição',
            'date'        => 'data',
            'month'       => 'mês',
        ];
    }

    public function updateRules(): array
    {
        return [
            'value'       => 'numeric',
            'description' => 'max:255',
            'date'        => 'date',
            'month'       => 'digits_between:1,12',
        ];
    }

    public function createRules(): array
    {
        return [
            'user_id'     => [
                'required',
                Rule::exists('users', 'id')
                    ->where('id', auth()->id())
            ],
            'income_id'   => Rule::exists('incomes', 'id')
                ->where('user_id', auth()->id()),
            'value'       => 'required|numeric',
            'description' => 'max:255',
            'date'        => 'required|date',
            'month'       => 'required|digits_between:1,12',
        ];
    }
}
