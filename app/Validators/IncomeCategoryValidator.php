<?php

namespace App\Validators;

use Illuminate\Validation\Rule;

class IncomeCategoryValidator extends AbstractSaveModelValidator
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
            'name'    => [
                'required' ,
                Rule::unique('income_categories', 'name')
                    ->where('user_id', auth()->id())
                ->ignore(request('id'))
            ],
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
            'name'    => ['required', Rule::unique('income_categories', 'name')->where('user_id', auth()->id())],
        ];
    }
}
