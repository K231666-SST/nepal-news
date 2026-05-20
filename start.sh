#!/bin/bash
set -e

echo "🚀 Nepal News Australia starting..."
cd /var/www/html

# Debug — show what env vars Render injected
echo "ENV CHECK: DB_HOST=${DB_HOST}"
echo "ENV CHECK: APP_KEY=${APP_KEY}"

# Write .env — use printf to avoid heredoc expansion issues
printf "APP_NAME=\"Nepal News Australia\"\n" > .env
printf "APP_ENV=production\n" >> .env
printf "APP_KEY=%s\n" "${APP_KEY}" >> .env
printf "APP_DEBUG=false\n" >> .env
printf "APP_URL=https://nepal-news.onrender.com\n" >> .env
printf "LOG_CHANNEL=stderr\n" >> .env
printf "LOG_LEVEL=error\n" >> .env
printf "DB_CONNECTION=mysql\n" >> .env
printf "DB_HOST=%s\n" "${DB_HOST}" >> .env
printf "DB_PORT=%s\n" "${DB_PORT}" >> .env
printf "DB_DATABASE=%s\n" "${DB_DATABASE}" >> .env
printf "DB_USERNAME=%s\n" "${DB_USERNAME}" >> .env
printf "DB_PASSWORD=%s\n" "${DB_PASSWORD}" >> .env
printf "DB_SSL_CA=/etc/ssl/certs/ca-certificates.crt\n" >> .env
printf "MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt\n" >> .env
printf "CACHE_STORE=file\n" >> .env
printf "SESSION_DRIVER=file\n" >> .env
printf "QUEUE_CONNECTION=sync\n" >> .env
printf "GROQ_API_KEY=%s\n" "${GROQ_API_KEY}" >> .env

echo "✅ .env written"
cat .env | grep DB_HOST

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
