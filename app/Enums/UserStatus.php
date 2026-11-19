<?php

namespace App\Enums;

/** Stato dell'account, gestito dal CMS. */
enum UserStatus: string
{
    case Active = 'active';
    case Suspended = 'suspended';
    case Blocked = 'blocked';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Attivo',
            self::Suspended => 'Sospeso',
            self::Blocked => 'Bloccato',
        };
    }
}
