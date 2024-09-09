<?php

namespace App\Validators;

use App\Enums\ValidationType;
use App\Validators\Contracts\SaveModelValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class AbstractSaveModelValidator implements SaveModelValidator
{

    /**
     * @throws ValidationException
     */
    public function validate(array $data, ValidationType $type): array
    {
        $rules = $this->getRules($type);
        $validator = Validator::make($data, $rules, $this->messages(), $this->attributes());

        return $validator->validated();
    }

    public function createRules(): array
    {
        return [];
    }

    public function updateRules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function getRules(ValidationType $type): array
    {

        if ($type->value === ValidationType::UPDATE->value) {
            return $this->updateRules();
        }

        return $this->createRules();
    }
}
