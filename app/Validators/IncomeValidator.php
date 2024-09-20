<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class IncomeValidator extends BaseValidator
{

    public function attributes(): array
    {
        return [
            'value'       => 'valor',
            'category_id' => 'categoria',
            'description' => 'descrição',
            'payment_day' => 'dia do pagamento',
        ];
    }

    public function updateRules(): array
    {
        return [
            'value'       => 'sometimes|required|numeric',
            'category_id' => Rule::exists('income_categories', 'id')
                ->where(function ($query) {
                    $query->where('user_id', auth()->id());
                    $query->orWhereNull('user_id');
                }),
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
            'category_id' => [
                'required',
                Rule::exists('income_categories', 'id')
                    ->where(function ($query) {
                        $query->where('user_id', auth()->id());
                        $query->orWhereNull('user_id');
                    })
            ],
            'payment_day' => 'required|digits_between:1,31',
            'description' => 'required|max:255',
        ];
    }
}
