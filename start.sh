#!/bin/bash
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
ENVEOF

echo "DB_HOST=$DB_HOST"

php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

echo "=== Running migrations in background ==="
(php artisan migrate:fresh --force --seed --no-interaction 2>&1 && echo "MIGRATIONS DONE") &

echo "=== Starting Apache immediately ==="
exec apache2-foreground
