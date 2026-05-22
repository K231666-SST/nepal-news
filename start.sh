#!/bin/bash
cd /var/www/html

echo "=== Writing .env ==="
printf "APP_NAME=\"Nepal News Australia\"\n" > .env
printf "APP_ENV=production\n" >> .env
printf "APP_KEY=%s\n" "${APP_KEY}" >> .env
printf "APP_DEBUG=true\n" >> .env
printf "APP_URL=https://nepal-news.onrender.com\n" >> .env
printf "LOG_CHANNEL=stderr\n" >> .env
printf "DB_CONNECTION=mysql\n" >> .env
printf "DB_HOST=%s\n" "${DB_HOST}" >> .env
printf "DB_PORT=%s\n" "${DB_PORT}" >> .env
printf "DB_DATABASE=%s\n" "${DB_DATABASE}" >> .env
printf "DB_USERNAME=%s\n" "${DB_USERNAME}" >> .env
printf "DB_PASSWORD=%s\n" "${DB_PASSWORD}" >> .env
printf "DB_SSL_CA=/etc/ssl/certs/ca-certificates.crt\n" >> .env
printf "CACHE_STORE=file\n" >> .env
printf "SESSION_DRIVER=file\n" >> .env
printf "QUEUE_CONNECTION=sync\n" >> .env
printf "GROQ_API_KEY=%s\n" "${GROQ_API_KEY}" >> .env

echo "DB=$DB_HOST"

php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "=== Migrate ==="
php artisan migrate --force --no-interaction

echo "=== Seed if empty ==="
php artisan db:seed --force --no-interaction 2>/dev/null || true

php artisan config:cache
php artisan storage:link --force 2>/dev/null || true

echo "=== START ==="
exec apache2-foreground
