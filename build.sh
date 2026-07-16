#!/bin/bash

# Install PHP & Composer
apt-get update -qq
apt-get install -y -qq php8.2-cli php8.2-mbstring php8.2-xml php8.2-curl php8.2-pgsql unzip > /dev/null 2>&1
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer > /dev/null 2>&1

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Cache Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
