# Etapa única: PHP + Nginx no mesmo container
FROM php:8.3-fpm

# Instala dependências do sistema e Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        sockets \
        intl \
        zip \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia os arquivos da aplicação
COPY . .

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Copia a configuração customizada do Nginx
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Expõe porta 80
EXPOSE 80

# Comando para iniciar PHP-FPM + Nginx
CMD php-fpm -D && nginx -g 'daemon off;'
