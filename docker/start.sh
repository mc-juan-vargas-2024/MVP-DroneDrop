#!/bin/sh

# Crear directorios necesarios
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/cache

# Limpiar caché (nunca cachear config en producción con Render,
# porque las env vars se inyectan en runtime, no en build time)
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Solo cachear vistas (seguro, no depende de env vars en runtime)
php artisan view:cache
php artisan storage:link

# Correr migraciones
php artisan migrate --force

# Iniciar PHP-FPM en background
php-fpm -D

# Iniciar Nginx
nginx -g "daemon off;"