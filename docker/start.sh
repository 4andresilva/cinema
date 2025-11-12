#!/bin/bash
set -e

echo "🚀 Starting application..."

# Limpa caches antigos
echo "🧹 Clearing old caches..."
php artisan config:clear
php artisan cache:clear

# Cacheia configurações com as variáveis de ambiente do Render
echo "⚡ Caching configurations..."
php artisan config:cache

# Opcional: Roda migrations
# echo "📊 Running migrations..."
# php artisan migrate --force

echo "✅ Application ready!"

# Inicia PHP-FPM em background
php-fpm -D

# Inicia Nginx em foreground
exec nginx -g 'daemon off;'