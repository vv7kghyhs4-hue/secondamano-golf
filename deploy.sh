#!/usr/bin/env bash
#
# Secondamano.golf – aggiornamento del sito sul server.
#
# Uso (sul server, dalla cartella del progetto):
#     ./deploy.sh
#
# Variabili facoltative, se sull'hosting i comandi hanno un nome diverso:
#     PHP_BIN=/usr/bin/php8.3 COMPOSER_BIN=~/composer.phar ./deploy.sh
#     DEPLOY_BRANCH=main ./deploy.sh
#
# Cosa fa: mette il sito in manutenzione, scarica l'ultima versione da GitHub,
# installa le librerie, compila la grafica (se Node è disponibile), aggiorna
# il database, rigenera le cache e rimette il sito online.
# Non tocca mai il file .env né le foto caricate (cartella storage).

set -euo pipefail

cd "$(dirname "$0")"

PHP="${PHP_BIN:-php}"
COMPOSER="${COMPOSER_BIN:-composer}"
BRANCH="${DEPLOY_BRANCH:-main}"

step() { printf '\n\033[1;32m==> %s\033[0m\n' "$1"; }
fail() { printf '\n\033[1;31mERRORE: %s\033[0m\n' "$1" >&2; exit 1; }

# --- Controlli preliminari ---------------------------------------------------
step "Controlli preliminari"

[ -f .env ] || fail "manca il file .env (copia .env.example in .env e compilalo)."
grep -qE '^APP_KEY=.+' .env || fail "APP_KEY vuota nel .env: esegui '$PHP artisan key:generate'."

PHP_VERSION=$("$PHP" -r 'echo PHP_VERSION;')
"$PHP" -r 'exit(version_compare(PHP_VERSION, "8.3.0", ">=") ? 0 : 1);' \
    || fail "serve PHP 8.3 o superiore (trovato $PHP_VERSION). Indica il percorso giusto con PHP_BIN=..."
echo "PHP $PHP_VERSION"

command -v "$COMPOSER" >/dev/null 2>&1 || [ -f "$COMPOSER" ] \
    || fail "Composer non trovato. Indica il percorso con COMPOSER_BIN=..."

# --- Manutenzione -----------------------------------------------------------
step "Sito in manutenzione"
"$PHP" artisan down --retry=15 --refresh=15 || true

# Qualunque cosa succeda, alla fine il sito torna online.
trap 'step "Sito di nuovo online"; "$PHP" artisan up' EXIT

# --- Codice -----------------------------------------------------------------
step "Scarico l'ultima versione da GitHub (ramo $BRANCH)"
git fetch --prune origin "$BRANCH"
git reset --hard "origin/$BRANCH"
echo "Versione: $(git log -1 --format='%h – %s')"

step "Librerie PHP"
"$COMPOSER" install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# --- Grafica ----------------------------------------------------------------
step "Grafica e caratteri"
if command -v npm >/dev/null 2>&1; then
    npm ci --no-audit --no-fund
    npm run build
elif [ -f public/build/manifest.json ]; then
    echo "npm non disponibile sul server: uso la grafica già compilata in public/build."
else
    fail "npm non disponibile e grafica non compilata. Compila con 'npm run build' su un altro computer e carica la cartella public/build."
fi

# --- Database e cache -------------------------------------------------------
step "Aggiornamento del database"
"$PHP" artisan migrate --force

step "Collegamento cartella foto"
[ -L public/storage ] || "$PHP" artisan storage:link

step "Cache"
"$PHP" artisan optimize:clear
"$PHP" artisan optimize

# Riavvia eventuali processi in coda, così usano il codice nuovo.
"$PHP" artisan queue:restart || true

step "Deploy completato"
