<?php

namespace App\Validators;

use Illuminate\Contracts\Validation\Factory;
use Prettus\Validator\AbstractValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class BaseValidator extends AbstractValidator
{

    protected $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function passes($action = null): bool
    {
        $rules      = $this->getRulesFromMethod($action);
        $messages   = $this->getMessages();
        $attributes = $this->getAttributes();
        $validator  = $this->validator->make($this->data, $rules, $messages, $attributes);

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    public function getRulesFromMethod($action = null): array
    {
        if ($action === ValidatorInterface::RULE_UPDATE) {
            return $this->updateRules();
        }

        return $this->createRules();
    }

    public function updateRules(): array
    {
        return [];
    }

    public function createRules(): array
    {
        return [];
    }
}
