FROM php:8.2-fpm-bullseye

# Instalar Node.js 18 (versión moderna)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -

RUN apt-get update && apt-get install -y \
    nginx \
    curl \
    zip \
    unzip \
    nodejs \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 8080

CMD ["/bin/sh", "/var/www/docker/start.sh"]