# Secondamano.golf

Piattaforma di annunci di attrezzatura da golf usata e nuova, per l'Italia e il Canton Ticino.
Prima versione: sito web responsive in PHP (Laravel). In seguito: app iOS e Android sulle stesse API.

Analisi funzionale completa: Doc "Secondamano.golf – Analisi funzionale v1.0".

## Stato

| Fase | Contenuto | Stato |
| --- | --- | --- |
| 1. Fondamenta | progetto Laravel, database, kit grafico, home provvisoria | fatto |
| 2. Utenti | registrazione con codice email, login Apple e Google, profilo | da fare |
| 3. Annunci | pubblicazione con foto, ricerca, pagina annuncio, preferiti | da fare |
| 4. Contatti | chat interna, copie via email, blocchi e segnalazioni | da fare |
| 5. CMS e pubblicità | amministrazione, statistiche, AdSense, cookie, pagine legali | da fare |
| 6. Lancio web | test, velocità, SEO, messa online | da fare |

## Requisiti dell'hosting

- PHP 8.3 o superiore, con estensioni `pdo_mysql`, `mbstring`, `intl`, `gd`, `zip`, `curl`
- MySQL 8 o MariaDB 10.6+
- Accesso SSH e Composer 2
- Cron (attività pianificate, una volta al minuto)
- La cartella pubblica del sito deve puntare a `public/`
- Certificato HTTPS

Node.js serve solo per compilare grafica e caratteri (`npm run build`), anche su un altro computer.

## Installazione

```bash
git clone https://github.com/vv7kghyhs4-hue/secondamano-golf.git
cd secondamano-golf
composer install --no-dev --optimize-autoloader
cp .env.example .env          # poi compilare database, email, URL
php artisan key:generate
php artisan migrate --seed    # crea le tabelle e carica province, categorie, marche
php artisan storage:link
npm ci && npm run build
```

## Aggiornare il sito (deploy)

Dopo la prima installazione, ogni aggiornamento si fa sul server con un solo comando, dalla cartella del progetto:

```bash
./deploy.sh
```

Lo script mette il sito in manutenzione, scarica l'ultima versione da GitHub, installa le librerie, compila la grafica, aggiorna il database e le cache, poi rimette il sito online (anche in caso di errore). Non tocca il file `.env` né le foto caricate.

Se sull'hosting PHP o Composer hanno un nome diverso:

```bash
PHP_BIN=/usr/bin/php8.3 COMPOSER_BIN=~/composer.phar ./deploy.sh
```

Se sul server non c'è Node.js, compilare la grafica su un altro computer (`npm run build`) e caricare la cartella `public/build`.

Cron da aggiungere sul server:

```
* * * * * cd /percorso/secondamano-golf && php artisan schedule:run >> /dev/null 2>&1
```

## Sviluppo in locale

```bash
composer install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install && npm run build
php artisan serve            # http://localhost:8000
php artisan test             # test automatici
```

## Dove si trovano le regole

- `config/secondamano.php`: durata annunci (60 giorni), limite per i privati (30), foto (5), lunghezze di titolo e descrizione, email del modulo di contatto.
- `database/seeders/`: province (Canton Ticino + 107 province italiane), categorie, marche, spazi pubblicitari.
- `resources/css/app.css`: colori e caratteri del kit grafico.
- `public/images/`: logo, icona app, favicon.
