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

# Remove TODOS os arquivos de configuração padrão do Nginx
RUN rm -f /etc/nginx/sites-enabled/default \
    && rm -f /etc/nginx/sites-available/default \
    && rm -f /etc/nginx/conf.d/*.conf

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia o default.conf
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia aplicação
COPY . .

# Cria o arquivo .env se não existir
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Ajusta permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Instala dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Gera a chave da aplicação
RUN php artisan key:generate --force

# NÃO CACHE CONFIG AQUI! Apenas route e view
RUN php artisan route:cache \
    && php artisan view:cache

EXPOSE 80

# Script de inicialização que cacheia config DEPOIS das env vars estarem disponíveis
CMD php artisan config:cache && \
    php-fpm -D && \
    nginx -g 'daemon off;'