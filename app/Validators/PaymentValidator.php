<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class PaymentValidator extends BaseValidator
{
    public function attributes(): array
    {
        return [
            'value'       => 'valor',
            'description' => 'descrição',
            'date'        => 'data',
        ];
    }

    public function updateRules(): array
    {
        return [
            'value'       => 'sometimes|required|numeric',
            'description' => 'nullable|max:255',
            'date'        => 'sometimes|required|date',
            'income_id'   => ['nullable', Rule::exists('incomes', 'id')
                ->where('user_id', auth()->id())],
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
        ];
    }
}
