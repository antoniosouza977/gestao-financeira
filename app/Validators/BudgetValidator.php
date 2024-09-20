<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class BudgetValidator extends BaseValidator
{

    public function attributes(): array
    {
        return [
            'name'        => 'nome',
            'value'       => 'valor',
            'category_id' => 'categoria',
        ];
    }

    public function updateRules(): array
    {
        return [
            'name'        => 'sometimes|required',
            'value'       => 'sometimes|required|numeric',
            'category_id' => Rule::exists('expense_categories', 'id')
                ->where(function ($query) {
                    $query->where('user_id', auth()->id());
                    $query->orWhereNull('user_id');
                })
            ,
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
            'name'        => 'required|max:255',
            'value'       => 'required|numeric',
            'category_id' => [
                'required',
                Rule::exists('expense_categories', 'id')
                    ->where(function ($query) {
                        $query->where('user_id', auth()->id());
                        $query->orWhereNull('user_id');
                    })
            ],
        ];
    }
}
