#!/bin/bash
set -e

echo "🚀 Starting application..."

# Remove TODOS os arquivos de cache manualmente
echo "🧹 Removing all cache files..."
rm -rf /var/www/bootstrap/cache/config.php
rm -rf /var/www/bootstrap/cache/routes-*.php
rm -rf /var/www/bootstrap/cache/packages.php
rm -rf /var/www/bootstrap/cache/services.php

# Limpa caches via artisan
echo "🧹 Clearing caches via artisan..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cacheia configurações com as variáveis de ambiente do Render
echo "⚡ Caching configurations..."
php artisan config:cache

chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache


# Debug: Mostra as configurações do banco
echo "🔍 Database configuration:"
php artisan tinker --execute="echo 'DB_CONNECTION: ' . config('database.default') . PHP_EOL;"
php artisan tinker --execute="echo 'DB_HOST: ' . config('database.connections.pgsql.host') . PHP_EOL;"
php artisan tinker --execute="echo 'DB_USERNAME: ' . config('database.connections.pgsql.username') . PHP_EOL;"
php artisan optimize:clear || true

echo "✅ Application ready!"

# Inicia PHP-FPM em background
php-fpm -D

# Inicia Nginx em foreground
exec nginx -g 'daemon off;'