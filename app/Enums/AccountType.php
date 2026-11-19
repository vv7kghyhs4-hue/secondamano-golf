<?php

namespace App\Enums;

/** Tipo di utente: privato, pro shop o commerciante. */
enum AccountType: string
{
    case Private = 'private';
    case Proshop = 'proshop';
    case Dealer = 'dealer';

    public function label(): string
    {
        return match ($this) {
            self::Private => 'Privato',
            self::Proshop => 'Pro shop',
            self::Dealer => 'Commerciante',
        };
    }
}
