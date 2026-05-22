FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev sqlite3 libsqlite3-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql \
       mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    --no-interaction --no-scripts --prefer-dist \
    --ignore-platform-reqs

RUN npm install && npm run build 2>/dev/null || echo "No Vite build needed"

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chmod 775 /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/database

RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["bash", "/var/www/html/start.sh"]
