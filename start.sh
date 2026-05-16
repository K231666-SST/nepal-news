#!/bin/bash
set -e

echo "🚀 Nepal News Australia starting..."
cd /var/www/html

cat > .env << ENVEOF
APP_NAME="Nepal News Australia"
APP_ENV=production
APP_KEY=$APP_KEY
APP_DEBUG=false
APP_URL=https://nepal-news.onrender.com
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
GROQ_API_KEY=$GROQ_API_KEY
OPENWEATHER_API_KEY=$OPENWEATHER_API_KEY
METAL_PRICE_API_KEY=$METAL_PRICE_API_KEY
EXCHANGE_RATE_API_KEY=$EXCHANGE_RATE_API_KEY
ENVEOF

echo "✅ DB_HOST=$DB_HOST"
echo "✅ DB_PORT=$DB_PORT"

php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true

echo "📦 Running migrations..."
php artisan migrate --force --no-interaction

ARTICLE_COUNT=$(php artisan tinker --execute="echo \App\Models\Article::count();" 2>/dev/null | grep -o '[0-9]*' | tail -1)
if [ -z "$ARTICLE_COUNT" ] || [ "$ARTICLE_COUNT" = "0" ]; then
    echo "🌱 Seeding..."
    php artisan db:seed --force --no-interaction 2>/dev/null || true
else
    echo "✅ Already seeded ($ARTICLE_COUNT articles)"
fi

php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true

echo "✅ Ready!"
apache2-foreground
