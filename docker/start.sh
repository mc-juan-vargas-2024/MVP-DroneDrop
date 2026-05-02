#!/bin/sh

# Crear directorios necesarios
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/cache

# Limpiar caché primero
php artisan cache:clear
php artisan config:clear
php artisan view:clear

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