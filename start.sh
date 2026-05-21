#!/bin/bash
set -e
cd /var/www/html

echo "=== Writing .env ==="
cat > .env << ENVEOF
APP_NAME="Nepal News Australia"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=true
APP_URL=https://nepal-news.onrender.com
LOG_CHANNEL=stderr
DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
DB_SSL_CA=/etc/ssl/certs/ca-certificates.crt
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
GROQ_API_KEY=${GROQ_API_KEY}
OPENWEATHER_API_KEY=${OPENWEATHER_API_KEY}
METAL_PRICE_API_KEY=${METAL_PRICE_API_KEY}
EXCHANGE_RATE_API_KEY=${EXCHANGE_RATE_API_KEY}
ENVEOF

echo "DB_HOST = $DB_HOST"

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "=== Running migrations ==="
php artisan migrate:fresh --force --seed

echo "=== Caching ==="
php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true

echo "=== READY ==="
apache2-foreground
