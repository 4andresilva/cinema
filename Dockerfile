# Etapa 1 - PHP com dependências
FROM php:8.3-fpm AS php-base

ARG user=andre
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev libicu-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd sockets intl zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Instala dependências Laravel
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Etapa 2 - Nginx + PHP
FROM nginx:1.25 AS production

# Copia o Nginx config
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia o PHP-FPM e app da etapa anterior
COPY --from=php-base /usr/local /usr/local
COPY --from=php-base /var/www /var/www

WORKDIR /var/www

EXPOSE 80

# Rodar Nginx em foreground e PHP-FPM junto
CMD php-fpm -D && nginx -g 'daemon off;'
