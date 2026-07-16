#!/bin/bash

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install & build frontend
npm install
npm run build

# Cache Laravel config & routes
php artisan config:cache
php artisan route:cache
php artisan view:cache
