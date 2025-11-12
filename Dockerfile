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

# Remove configurações padrão do Nginx
RUN rm -f /etc/nginx/sites-enabled/default \
    && rm -f /etc/nginx/sites-available/default \
    && rm -f /etc/nginx/conf.d/*.conf

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia configuração do Nginx
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia aplicação
COPY . .

# Remove o .env local (usar apenas as variáveis do Render)
RUN rm -f .env

# Ajusta permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Instala dependências
RUN composer install --no-dev --optimize-autoloader

# Cache apenas route e view (NÃO config!)
RUN php artisan route:cache \
    && php artisan view:cache

EXPOSE 80

# Limpa cache antigo e cacheia config no runtime (quando as env vars estão disponíveis)
CMD php artisan config:clear && \
    php artisan config:cache && \
    php-fpm -D && \
    nginx -g 'daemon off;'