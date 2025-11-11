# Etapa 1 - PHP com dependências
FROM php:8.3-fpm as php-base

ARG user=andre
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev libicu-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd sockets intl zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Etapa 2 - Nginx + PHP
FROM nginx:1.25

# Copia o Nginx config
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia o PHP-FPM da etapa anterior
COPY --from=php-base /usr/local/bin/php /usr/local/bin/php
COPY --from=php-base /usr/local/sbin/php-fpm /usr/local/sbin/php-fpm
COPY --from=php-base /usr/local/etc /usr/local/etc
COPY --from=php-base /var/www /var/www

EXPOSE 80

WORKDIR /var/www

CMD service nginx start && php-fpm
