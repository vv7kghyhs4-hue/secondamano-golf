<?php

namespace App\Enums;

/** Condizione dell'articolo. */
enum ListingCondition: string
{
    case New = 'new';
    case Used = 'used';
    case Defective = 'defective';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Nuovo',
            self::Used => 'Usato',
            self::Defective => 'Difettoso',
        };
    }
}
