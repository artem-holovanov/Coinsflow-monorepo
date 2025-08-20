FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev libonig-dev \
    && docker-php-ext-install intl pdo pdo_pgsql zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html