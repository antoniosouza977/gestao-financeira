<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class ExpenseValidator extends BaseValidator
{

    public function attributes(): array
    {
        return [
            'value'       => 'valor',
            'budget_id'   => 'categoria',
            'description' => 'descrição',
            'payment_day' => 'dia do pagamento',
        ];
    }

    public function updateRules(): array
    {
        return [
            'value'       => 'sometimes|required|numeric',
            'budget_id'   => Rule::exists('budgets', 'id')
                ->where('user_id', auth()->id()),
            'payment_day' => 'sometimes|required|digits_between:1,31',
            'description' => 'sometimes|required|max:255',
        ];
    }

    public function createRules(): array
    {
        return [
            'user_id'     => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')
                    ->where('id', auth()->id())
            ],
            'value'       => 'required|numeric',
            'budget_id'   => [
                'required',
                Rule::exists('budgets', 'id')
                    ->where('user_id', auth()->id()),
            ],
            'payment_day' => 'required|digits_between:1,31',
            'description' => 'required|max:255',
        ];
    }
}
