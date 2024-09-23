<?php

namespace App\Enums;

class Months
{
    public const JANUARY   = 1;
    public const FEBRUARY  = 2;
    public const MARCH     = 3;
    public const APRIL     = 4;
    public const MAY       = 5;
    public const JUNE      = 6;
    public const JULY      = 7;
    public const AUGUST    = 8;
    public const SEPTEMBER = 9;
    public const OCTOBER   = 10;
    public const NOVEMBER  = 11;
    public const DECEMBER  = 12;

    public static array $labels = [
        self::JANUARY   => 'Janeiro',
        self::FEBRUARY  => 'Fevereiro',
        self::MARCH     => 'Março',
        self::APRIL     => 'Abril',
        self::MAY       => 'Maio',
        self::JUNE      => 'Junho',
        self::JULY      => 'Julho',
        self::AUGUST    => 'Agosto',
        self::SEPTEMBER => 'Setembro',
        self::OCTOBER   => 'Outubro',
        self::NOVEMBER  => 'Novembro',
        self::DECEMBER  => 'Dezembro',
    ];
}
