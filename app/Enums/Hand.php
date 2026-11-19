<?php

namespace App\Enums;

/** Mano del bastone. */
enum Hand: string
{
    case Right = 'right';
    case Left = 'left';

    public function label(): string
    {
        return match ($this) {
            self::Right => 'Destro',
            self::Left => 'Mancino',
        };
    }
}
