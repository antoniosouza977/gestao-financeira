<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class TransactionValidator extends BaseValidator
{
    public function attributes(): array
    {
        return [
            'value' => 'valor',
            'description' => 'descrição',
            'date' => 'data',
        ];
    }

    public function updateRules(): array
    {
        return [
            'value' => 'sometimes|required|decimal:0,2|gt:0',
            'description' => 'nullable|max:255',
            'date' => 'sometimes|required|date',
            'category_id' => ['nullable', Rule::exists('categories', 'id')
                ->where('user_id', auth()->id())],
        ];
    }

    public function createRules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')
                    ->where('id', auth()->id()),
            ],
            'category_id' => ['nullable', Rule::exists('categories', 'id')
                ->where('user_id', auth()->id())],
            'transaction_promise_id' => ['nullable', Rule::exists('transaction_promises', 'id')
                ->where('user_id', auth()->id())],
            'value' => 'required|decimal:0,2|gt:0',
            'type' => 'required|digits_between:1,2',
            'description' => 'max:255',
            'date' => 'required|date',
        ];
    }
}
