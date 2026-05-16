**CPRO306 — CAPSTONE PROJECT**

**Week 11 — Deployment Documentation**

_Cloud Infrastructure & Live Deployment Guide_

**Nepal News Australia**

_Bilingual Nepali-Australian Community News Portal_

| **Field** | **Details** |
| --- | --- |
| Team | Team 9 — Skillup Labs WIL Program |
| Unit | CPRO306 Capstone Project — Kent Institute Australia |
| Week | Week 11 — May 2026 |
| Supervisor | Nabin Singh — wil@skilluplabs.com.au |
| Members | Shushil Shah Teli (K231666) · Subash Khatri (K250035) · Sujan Shrestha (K250040) |
| GitHub | https://github.com/K231666-SST/nepal-news |

# **1\. Deployment Overview**

Nepal News Australia has been deployed to a cloud production environment using a Docker-containerised Laravel application hosted on Render.com, connected to a Railway.app-managed MySQL 8.0 database. This document provides a complete reference for the deployment architecture, configuration, and maintenance procedures.

## **1.1 Live URLs**

| **Environment** | **URL** | **Status** |
| --- | --- | --- |
| Production (Render.com) | https://nepal-news.onrender.com | Live ✅ |
| Database (Railway.app) | yamanote.proxy.rlwy.net:30133 | Connected ✅ |
| GitHub Repository | https://github.com/K231666-SST/nepal-news | Public ✅ |
| Local Development | http://localhost:8080 | Running ✅ |

# **2\. Infrastructure Architecture**

## **2.1 Technology Stack**

| **Component** | **Technology** | **Details** |
| --- | --- | --- |
| Web Server | Apache 2.4 + PHP 8.2 | Containerised via Docker on Render.com |
| Application Framework | Laravel 13.7.0 | PHP MVC framework |
| Database | MySQL 8.0 | Hosted on Railway.app Hobby plan |
| Container | Docker (php:8.2-apache) | Custom Dockerfile with Laravel config |
| CI/CD | GitHub → Render auto-deploy | Push to main branch triggers redeploy |
| AI Service | Groq API (llama-3.1-8b-instant) | Free tier for Guru chatbot |

# **3\. Deployment Files**

## **3.1 Dockerfile**

FROM php:8.2-apache RUN apt-get update && apt-get install -y \\ git curl libpng-dev libonig-dev libxml2-dev \\ zip unzip libzip-dev \\ && docker-php-ext-install pdo_mysql mbstring \\ exif pcntl bcmath gd zip \\ && apt-get clean && rm -rf /var/lib/apt/lists/\* COPY --from=composer:latest /usr/bin/composer /usr/bin/composer WORKDIR /var/www/html COPY . . RUN php -d memory_limit=-1 /usr/bin/composer install \\ --no-dev --optimize-autoloader \\ --no-interaction --no-scripts \\ --prefer-dist --ignore-platform-reqs RUN cp .env.production .env RUN chown -R www-data:www-data /var/www/html RUN chmod -R 755 /var/www/html/storage RUN a2enmod rewrite COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf EXPOSE 80 CMD \["bash", "/var/www/html/start.sh"\]

## **3.2 start.sh — Container Startup Script**

#!/bin/bash set -e cd /var/www/html # Write .env from Render environment variables cat > .env &lt;< ENVEOF APP_NAME="Nepal News Australia" APP_ENV=production APP_KEY=$APP_KEY APP_URL=$APP_URL DB_CONNECTION=mysql DB_HOST=$DB_HOST DB_PORT=$DB_PORT DB_DATABASE=$DB_DATABASE DB_USERNAME=$DB_USERNAME DB_PASSWORD=$DB_PASSWORD CACHE_STORE=file SESSION_DRIVER=file GROQ_API_KEY=$GROQ_API_KEY ENVEOF php artisan config:clear && php artisan route:clear && php artisan view:clear php artisan migrate --force --no-interaction php artisan db:seed --force --no-interaction 2&gt;/dev/null || true php artisan config:cache php artisan storage:link --force 2>/dev/null || true apache2-foreground

# **4\. Environment Variables (Render Dashboard)**

| **Variable** | **Value** | **Purpose** |
| --- | --- | --- |
| APP_KEY | base64:QEb/yp+... | Laravel encryption key |
| APP_ENV | production | Environment mode |
| APP_DEBUG | false | Disable debug output |
| APP_URL | https://nepal-news.onrender.com | Application URL |
| DB_HOST | yamanote.proxy.rlwy.net | Railway MySQL hostname |
| DB_PORT | 30133 | Railway MySQL port |
| DB_DATABASE | railway | Database name |
| DB_USERNAME | root | Database user |
| DB_PASSWORD | \[secured\] | Database password |
| GROQ_API_KEY | gsk_\[secured\] | Guru AI chatbot API key |
| CACHE_STORE | file | File-based caching |
| SESSION_DRIVER | file | File-based sessions |

# **5\. Database Setup — Railway.app**

## **5.1 Railway MySQL Configuration**

- Service: MySQL 8.0 on Railway Hobby Plan (~$6 AUD/month)
- Region: US East (closest available to Australia)
- Public proxy URL: yamanote.proxy.rlwy.net:30133
- Database: railway (default)
- Migrations run automatically on container startup via start.sh

## **5.2 Database Seeding**

- 48+ articles seeded across 8 categories
- 5 community events seeded
- 4 user accounts seeded (admin, editor, contributor, reader)
- Advertisement positions seeded with placeholder images

# **6\. Continuous Deployment Pipeline**

| **Step** | **Action** | **Trigger** |
| --- | --- | --- |
| 1   | Developer pushes code to GitHub main branch | Manual git push |
| 2   | Render.com detects new commit via webhook | Automatic |
| 3   | Render pulls latest code from GitHub | Automatic |
| 4   | Docker build runs (installs dependencies) | Automatic |
| 5   | Container starts, start.sh executes | Automatic |
| 6   | Migrations run against Railway MySQL | Automatic |
| 7   | Application goes live at onrender.com URL | Automatic |

# **7\. Local Development Setup**

## **7.1 Prerequisites**

- XAMPP with PHP 8.2+ and MySQL on port 3307
- Composer (PHP dependency manager)
- Node.js (for any frontend asset compilation)
- Git (for version control)

## **7.2 Installation Steps**

1.  Clone repository: git clone https://github.com/K231666-SST/nepal-news.git
2.  Install dependencies: composer install
3.  Copy environment file: cp .env.example .env
4.  Configure .env: set DB_PORT=3307, DB_DATABASE=nepal_news
5.  Generate app key: php artisan key:generate
6.  Run migrations: php artisan migrate
7.  Seed database: php artisan db:seed
8.  Start server: php artisan serve --port=8080
9.  Visit: http://localhost:8080

# **8\. Demo Credentials**

| **Role** | **Email** | **Password** | **Access Level** |
| --- | --- | --- | --- |
| Administrator | admin@nepalnews.com.au | password | Full system access |
| Editor | editor@nepalnews.com.au | password | Publish/edit articles |
| Contributor | contributor@nepalnews.com.au | password | Create draft articles |
| Reader | reader@nepalnews.com.au | password | Read-only access |

# **9\. References**

Render (2024) Render Documentation — Docker Deploy. Available at: https://render.com/docs/docker

Railway (2024) Railway MySQL Documentation. Available at: https://docs.railway.app/databases/mysql

Docker (2024) Dockerfile Reference. Available at: https://docs.docker.com/engine/reference/builder/

Laravel (2024) Deployment Guide. Available at: https://laravel.com/docs/deployment

Mouat, A. (2015) Using Docker. Sebastopol: O'Reilly Media.