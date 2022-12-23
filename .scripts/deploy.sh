#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

# Pull the latest version of the app
git pull origin main

#  Install composer dependencies
~/constructor-iot-backend.na4u.ru/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Run migration
php artisan migrate

# Clear the old cache
php artisan clear-compiled
# Recreate cache
php artisan optimize


# Exit maintenance mode
php artisan up

echo "Deployment finished!"