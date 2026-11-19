<?php

/*
|--------------------------------------------------------------------------
| Regole di Secondamano.golf
|--------------------------------------------------------------------------
|
| Valori decisi nell'analisi funzionale v1.0 (19.11.2026). Si possono
| modificare qui senza toccare il codice.
|
*/

return [

    // Destinatario dei messaggi inviati dal modulo di contatto.
    'contact_email' => env('CONTACT_EMAIL', 'gianni@giorgetti.com'),

    'listings' => [
        // Durata massima di un annuncio pubblicato, in giorni.
        'duration_days' => 60,

        // Annunci attivi contemporaneamente per un utente privato.
        // Pro shop e commercianti non hanno limite.
        'max_active_private' => 30,

        'title_max' => 50,
        'description_max' => 1000,
        'photos_max' => 5,

        // Giorni in cui un annuncio venduto resta visibile con l'etichetta "Venduto".
        'sold_visible_days' => 7,
    ],

    'ads' => [
        // Valore predefinito: uno spazio pubblicitario ogni N annunci nelle liste.
        // Il valore effettivo si imposta dal CMS (tabella settings).
        'list_frequency' => 5,
    ],

];
