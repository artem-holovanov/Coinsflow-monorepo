FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev libonig-dev librabbitmq-dev \
    && docker-php-ext-install intl pdo pdo_pgsql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html