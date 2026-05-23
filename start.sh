#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

: "${PORT:=10000}"
export PORT

echo "=== [boot] PORT=$PORT  APP_ENV=${APP_ENV:-production} ==="

if [[ ! -f .env ]]; then
    echo "=== [boot] generating .env from environment ==="
    cat > .env <<ENVEOF
APP_NAME="${APP_NAME:-Nepal News Australia}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://nepal-news.onrender.com}

LOG_CHANNEL=${LOG_CHANNEL:-stderr}
LOG_LEVEL=${LOG_LEVEL:-error}

DB_CONNECTION=${DB_CONNECTION:-sqlite}
DB_DATABASE=${DB_DATABASE:-/var/www/html/database/database.sqlite}
DB_HOST=${DB_HOST:-}
DB_PORT=${DB_PORT:-}
DB_USERNAME=${DB_USERNAME:-}
DB_PASSWORD=${DB_PASSWORD:-}

CACHE_STORE=${CACHE_STORE:-file}
SESSION_DRIVER=${SESSION_DRIVER:-file}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}

WEATHER_API_KEY=${WEATHER_API_KEY:-}
METAL_API_KEY=${METAL_API_KEY:-}
OPENAI_API_KEY=${OPENAI_API_KEY:-}
GROQ_API_KEY=${GROQ_API_KEY:-}
EXCHANGE_RATE_API_KEY=${EXCHANGE_RATE_API_KEY:-}

MAIL_MAILER=${MAIL_MAILER:-log}
MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS:-noreply@nepalnewsaustralia.com.au}
MAIL_FROM_NAME="${MAIL_FROM_NAME:-Nepal News Australia}"
ENVEOF
fi

if [[ -z "${APP_KEY:-}" ]] && ! grep -q '^APP_KEY=base64:' .env; then
    echo "=== [boot] generating APP_KEY ==="
    php artisan key:generate --force --no-interaction
fi

if [[ "${DB_CONNECTION:-sqlite}" == "sqlite" ]]; then
    DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    echo "=== [boot] ensuring SQLite file at $DB_PATH ==="
    mkdir -p "$(dirname "$DB_PATH")"
    touch "$DB_PATH"
    chown www-data:www-data "$DB_PATH" || true
    chmod 664 "$DB_PATH" || true
fi

echo "=== [boot] fixing storage permissions ==="
chown -R www-data:www-data storage bootstrap/cache database || true
chmod -R 775 storage bootstrap/cache || true

echo "=== [boot] clearing stale caches ==="
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear  || true

echo "=== [boot] running migrations ==="
php artisan migrate --force --no-interaction

if [[ "${RUN_SEEDERS:-true}" == "true" ]]; then
    echo "=== [boot] seeding database (best effort) ==="
    php artisan db:seed --force --no-interaction || echo "[boot] seeding skipped/failed (non-fatal)"
fi

echo "=== [boot] linking storage ==="
php artisan storage:link --force || true

echo "=== [boot] caching config / routes / views ==="
php artisan config:cache || echo "[boot] config:cache failed (non-fatal)"
php artisan route:cache  || echo "[boot] route:cache failed (non-fatal)"
php artisan view:cache   || echo "[boot] view:cache failed (non-fatal)"

echo "=== [boot] starting Apache on :$PORT ==="
exec apache2-foreground
