<?php

namespace App\Enums;

/** Flessibilità dello shaft. */
enum ShaftFlex: string
{
    case Ladies = 'L';
    case Senior = 'A';
    case Regular = 'R';
    case Stiff = 'S';
    case ExtraStiff = 'X';

    public function label(): string
    {
        return match ($this) {
            self::Ladies => 'L – Ladies',
            self::Senior => 'A – Senior',
            self::Regular => 'R – Regular',
            self::Stiff => 'S – Stiff',
            self::ExtraStiff => 'X – Extra stiff',
        };
    }
}
