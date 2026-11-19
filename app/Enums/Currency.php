<?php

namespace App\Enums;

/** Valuta del prezzo, scelta dall'inserzionista. */
enum Currency: string
{
    case CHF = 'CHF';
    case EUR = 'EUR';

    public function label(): string
    {
        return match ($this) {
            self::CHF => 'Franco svizzero',
            self::EUR => 'Euro',
        };
    }

    /** Codice paese della bandierina mostrata accanto al prezzo. */
    public function flag(): string
    {
        return match ($this) {
            self::CHF => 'ch',
            self::EUR => 'it',
        };
    }
}
