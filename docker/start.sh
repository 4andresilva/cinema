#!/bin/bash

# Limpa caches antigos
php artisan config:clear
php artisan cache:clear

# Cacheia com as variáveis de ambiente corretas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Roda migrations (opcional)
# php artisan migrate --force

# Inicia PHP-FPM e Nginx
php-fpm -D
nginx -g 'daemon off;'