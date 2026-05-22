#!/bin/bash
set -e
cd /var/www/html

echo "=== Writing .env ==="
cat > .env << ENVEOF
APP_NAME="Nepal News Australia"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=https://nepal-news.onrender.com
LOG_CHANNEL=stderr
LOG_LEVEL=error
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
GROQ_API_KEY=${GROQ_API_KEY}
OPENWEATHER_API_KEY=${OPENWEATHER_API_KEY}
METAL_PRICE_API_KEY=${METAL_PRICE_API_KEY}
EXCHANGE_RATE_API_KEY=${EXCHANGE_RATE_API_KEY}
ENVEOF

echo "=== Ensuring SQLite file exists ==="
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod 775 /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

echo "=== Clearing caches ==="
php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

echo "=== Running migrations ==="
php artisan migrate --force --no-interaction

echo "=== Seeding database ==="
php artisan db:seed --force --no-interaction 2>/dev/null || echo "Seeding skipped"

echo "=== Caching for performance ==="
php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true

echo "=== READY — Starting Apache ==="
exec apache2-foreground
