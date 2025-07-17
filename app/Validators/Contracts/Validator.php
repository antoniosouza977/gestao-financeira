<?php

declare(strict_types=1);

namespace App\Validators\Contracts;

use App\Enums\ValidationType;

interface Validator
{
    public function validate(array $data, ValidationType $validationType): array;

    public function createRules(): array;

    public function updateRules(): array;
}
