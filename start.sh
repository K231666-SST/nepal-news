#!/bin/bash
set -e

echo "🚀 Starting Nepal News Australia..."

cd /var/www/html

# Clear all caches first
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force --no-interaction

# Seed if empty
echo "🌱 Checking seed..."
php artisan db:seed --force --no-interaction 2>/dev/null || true

# Rebuild caches after migration
php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true

echo "✅ Ready!"
apache2-foreground
