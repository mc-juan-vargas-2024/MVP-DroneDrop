#!/bin/sh

# Optimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Correr migraciones
php artisan migrate --force

# Iniciar PHP-FPM en background
php-fpm -D

# Iniciar Nginx
nginx -g "daemon off;"