<?php

namespace App\Enums;

/** Stato di una segnalazione. */
enum ReportStatus: string
{
    case Open = 'open';
    case Resolved = 'resolved';
    case Dismissed = 'dismissed';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Aperta',
            self::Resolved => 'Risolta',
            self::Dismissed => 'Archiviata',
        };
    }
}
