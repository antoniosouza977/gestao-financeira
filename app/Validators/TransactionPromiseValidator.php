<?php

declare(strict_types=1);

namespace App\Validators;

use App\Models\TransactionPromise;
use Illuminate\Validation\Rule;

class TransactionPromiseValidator extends BaseValidator
{
    public function attributes(): array
    {
        return [
            'value' => 'valor',
            'description' => 'descrição',
            'type' => 'tipo',
            'period_type' => 'tipo de recorrencia',
            'period_value' => 'período',
            'category_id' => 'categoria',
        ];
    }

    public function updateRules(): array
    {
        return [
            'category_id' => ['nullable', Rule::exists('categories', 'id')
                ->where('user_id', auth()->id())],
            'value' => 'sometimes|required|decimal:0,2|gt:0',
            'description' => 'nullable|max:255',
            'type' => 'sometimes|required|digits_between:1,2',
            'status' => 'sometimes|required|digits_between:0,1',
            'period_type' => 'sometimes|required|digits_between:1,5',
            'period_value' => [
                'nullable',
                'integer',
                Rule::requiredIf(request('period_type') != TransactionPromise::DAILY),
                $this->getPeriodDateValidation(),
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
                    ->where('id', auth()->id()),
            ],
            'category_id' => ['nullable', Rule::exists('categories', 'id')
                ->where('user_id', auth()->id())],
            'value' => 'required|decimal:0,2|gt:0',
            'description' => 'nullable|max:255',
            'type' => 'required|digits_between:1,2',
            'period_type' => 'required|digits_between:1,5',
            'period_value' => [
                'nullable',
                'integer',
                Rule::requiredIf(request('period_type') != TransactionPromise::DAILY),
                $this->getPeriodDateValidation(),
            ],
        ];
    }

    private function getPeriodDateValidation(): string
    {
        $periodType = request('period_type');
        $validation = '';

        switch ($periodType) {
            case TransactionPromise::DAILY:
                break;
            case TransactionPromise::WEEKLY:
                $validation = 'digits_between:1,7';
                break;
            case TransactionPromise::MONTHLY:
                $validation = 'between:1,31';
                break;
            case TransactionPromise::ANNUALLY:
                $validation = 'digits_between:1,12';
                break;
            case TransactionPromise::INSTALLMENT:
                $validation = 'digits_between:1,999';
                break;
        }

        return $validation;
    }
}
