<?php

namespace App\Enums;

/** Ciclo di vita di un annuncio. */
enum ListingStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Sold = 'sold';
    case Expired = 'expired';
    case Suspended = 'suspended';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Bozza',
            self::Published => 'Pubblicato',
            self::Sold => 'Venduto',
            self::Expired => 'Scaduto',
            self::Suspended => 'Sospeso',
        };
    }
}
