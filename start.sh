#!/bin/bash
set -e

echo "🚀 Starting Nepal News Australia..."

# Run migrations (safe - won't drop existing tables)
php artisan migrate --force --no-interaction

# Seed only if database is empty
ARTICLE_COUNT=$(php artisan tinker --execute="echo \App\Models\Article::count();" 2>/dev/null | tail -1)
if [ "$ARTICLE_COUNT" = "0" ] || [ -z "$ARTICLE_COUNT" ]; then
    echo "📦 Seeding database..."
    php artisan db:seed --force --no-interaction
fi

# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link --force 2>/dev/null || true

echo "✅ Ready!"

# Start Apache
apache2-foreground
