<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class OutgoValidator extends BaseValidator
{
    public function attributes(): array
    {
        return [
            'value'       => 'valor',
            'description' => 'descrição',
            'date'        => 'data',
            'budget_id'   => 'Orçamento'
        ];
    }

    public function updateRules(): array
    {
        return [
            'value'       => 'sometimes|required|numeric',
            'description' => 'nullable|max:255',
            'date'        => 'sometimes|required|date',
            'expense_id'  => ['nullable', Rule::exists('expenses', 'id')
                ->where('user_id', auth()->id())],
            'budget_id'   => ['nullable', Rule::exists('budgets', 'id')
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
            'expense_id'  => Rule::exists('expenses', 'id')
                ->where('user_id', auth()->id()),
            'budget_id'   => Rule::exists('budgets', 'id')
                ->where('user_id', auth()->id()),
            'value'       => 'required|numeric',
            'description' => 'max:255',
            'date'        => 'required|date',
        ];
    }
}
