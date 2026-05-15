#!/bin/bash
set -e

echo "🚀 Starting Nepal News Australia..."

cd /var/www/html

# Generate app key if not set
php artisan key:generate --force --no-interaction

# Run migrations
php artisan migrate --force --no-interaction

# Seed if empty
ARTICLE_COUNT=$(php artisan tinker --execute="echo App\Models\Article::count();" 2>/dev/null | grep -o '[0-9]*' | tail -1)
if [ "$ARTICLE_COUNT" = "0" ] || [ -z "$ARTICLE_COUNT" ]; then
    echo "📦 Seeding..."
    php artisan db:seed --force --no-interaction
fi

# Caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan storage:link --force 2>/dev/null || true

echo "✅ Ready!"
apache2-foreground
