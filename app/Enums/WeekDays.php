<?php

namespace App\Enums;

class WeekDays
{
    public const SUNDAY    = 1;
    public const MONDAY    = 2;
    public const TUESDAY   = 3;
    public const WEDNESDAY = 4;
    public const THURSDAY  = 5;
    public const FRIDAY    = 6;
    public const SATURDAY  = 7;

    public static array $labels = [
        self::SUNDAY    => 'Domingo',
        self::MONDAY    => 'Segunda-Feira',
        self::TUESDAY   => 'Terça-Feira',
        self::WEDNESDAY => 'Quarta-Feira',
        self::THURSDAY  => 'Quinta-Feira',
        self::FRIDAY    => 'Sexta-Feira',
        self::SATURDAY  => 'Sábado',
    ];
}
