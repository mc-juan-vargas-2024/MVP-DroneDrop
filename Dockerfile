FROM php:8.2-fpm-alpine

# Dependencias del sistema (agregamos postgresql-dev para libpq)
RUN apk add --no-cache \
    nginx \
    curl \
    zip \
    unzip \
    nodejs \
    npm \
    postgresql-dev

# Extensiones PHP (PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql opcache

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Compilar assets con Vite
RUN npm install && npm run build

# Permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage b