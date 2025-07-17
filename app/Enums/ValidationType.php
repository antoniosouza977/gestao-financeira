<?php

declare(strict_types=1);

namespace App\Enums;

enum ValidationType: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
}
