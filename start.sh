#!/bin/bash
set -e

echo "🚀 Starting Nepal News Australia..."
cd /var/www/html

echo "DB_HOST is: $DB_HOST"

cat > .env << ENVEOF
APP_NAME="Nepal News Australia"
APP_ENV=production
APP_KEY=$APP_KEY
APP_DEBUG=false
APP_URL=${APP_URL:-https://nepal-news-australia.onrender.com}
LOG_CHANNEL=stderr
LOG_LEVEL=error
DB_CONNECTION=mysql
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_DATABASE=$DB_DATABASE
DB_USERNAME=$DB_USERNAME
DB_PASSWORD=$DB_PASSWORD
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
ENVEOF

echo "✅ .env written - DB_HOST=$DB_HOST"

php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "📦 Running migrations..."
php artisan migrate --force --no-interaction

echo "🌱 Seeding..."
php artisan db:seed --force --no-interaction 2>/dev/null || true

php artisan config:cache
php artisan storage:link --force 2>/dev/null || true

echo "✅ Ready!"
apache2-foreground
