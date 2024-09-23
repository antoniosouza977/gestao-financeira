<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class CategoryValidator extends BaseValidator
{

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'type' => 'tipo',
        ];
    }

    public function updateRules(): array
    {
        return [
            'name' => 'sometimes|required|max:255',
            'type' => 'sometimes|required|digits_between:1,2',
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
            'name' => 'required|max:255',
            'type' => 'required|digits_between:1,2',
        ];
    }
}
