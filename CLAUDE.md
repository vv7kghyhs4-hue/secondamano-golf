# Secondamano.golf – istruzioni per lo sviluppo

Portale di annunci di attrezzatura da golf (Italia + Canton Ticino). Laravel 13, PHP 8.3, Blade + Tailwind CSS 4, MySQL in produzione, SQLite in locale e nei test.

## Regole del progetto

- Interfaccia, testi e messaggi solo in **italiano**; tenere i testi pronti per una futura traduzione in inglese (niente stringhe costruite concatenando parti di frase).
- Codice, nomi di tabelle e colonne in inglese; commenti brevi in italiano.
- Le regole di business stanno in `config/secondamano.php`, non scritte nel codice.
- Valute: CHF e EUR, mostrate sempre con la bandierina (`<x-price>`, `<x-currency-flag>`). Formato CHF `1'250`, EUR `1.250`.
- Pubblicità: solo tramite `<x-ad-slot position="...">`; mai spazi tra una foto e l'altra della gallery.
- Privacy: niente servizi esterni caricati senza consenso (caratteri ospitati in locale, niente Google Fonts).
- Accessibilità: pulsanti e link veri, `aria-label` sui pulsanti con sola icona, contrasto testo almeno 4.5:1.
- Il back-end deve esporre le stesse funzioni via API, perché le future app iOS/Android le useranno.

## Comandi

```bash
php artisan test          # tutti i test devono passare prima di ogni commit
php artisan migrate:fresh --seed
npm run build
```

## Riferimenti

- Analisi funzionale e decisioni: Doc "Secondamano.golf – Analisi funzionale v1.0" e progetto claude.ai "Secondamano.golf" (`analisi/decisioni.md`).
- Fasi di sviluppo e stato: `README.md`.
