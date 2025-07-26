FROM composer:2 as vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-dev --prefer-dist

FROM node:18 as node_modules

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install && npm run build

FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=vendor /app /var/www/html
COPY --from=node_modules /app /var/www/html
COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

RUN composer install --optimize-autoloader --no-dev

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000