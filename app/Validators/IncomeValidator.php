<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class IncomeValidator extends AbstractSaveModelValidator
{

    public function attributes(): array
    {
        return [
            'amount'      => 'valor',
            'category_id' => 'categoria',
        ];
    }

    public function updateRules(): array
    {
        return [
            'user_id'        => [
                'exists:users,id',
                Rule::exists('users', 'id')
                    ->where('id', auth()->id())
            ],
            'amount'         => 'numeric',
            'category_id'    => Rule::exists('income_categories', 'id')
                ->where(function ($query) {
                    $query->where('user_id', auth()->id());
                    $query->orWhereNull('user_id');
                }),
            'date'           => 'date_format:Y-m-d',
            'description'    => 'max:255',
            'monthly_income' => 'boolean',
        ];
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
            'category_id'    => [
                'required',
                Rule::exists('income_categories', 'id')
                    ->where(function ($query) {
                        $query->where('user_id', auth()->id());
                        $query->orWhereNull('user_id');
                    })
            ],
            'date'           => 'required|date_format:Y-m-d',
            'description'    => 'max:255',
            'monthly_income' => 'boolean',
        ];
    }
}
