<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class ExpenseCategoryValidator extends BaseValidator
{

    public function attributes(): array
    {
        return [
            'name' => 'nome',
        ];
    }

    public function updateRules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    public function createRules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')
                    ->where('id', auth()->id())
            ],
            'name'    => 'required',
        ];
    }
}
