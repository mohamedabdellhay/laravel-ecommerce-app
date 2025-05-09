#!/bin/bash
set -e

# Install dependencies if vendor directory doesn't exist
if [ ! -d "/var/www/html/vendor" ]; then
    composer install --no-interaction
fi

# Create .env file if it doesn't exist
if [ ! -f "/var/www/html/.env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Create storage link if it doesn't exist
if [ ! -d "/var/www/html/public/storage" ]; then
    php artisan storage:link
fi

# Run migrations
php artisan migrate --force

# Start PHP-FPM
exec "$@" 