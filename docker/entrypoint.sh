#!/bin/bash
set -e

# Ждем готовности файловой системы
sleep 1

# Проверяем наличие .env файла
if [ ! -f ".env" ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Генерируем ключ приложения если его нет
if [ -z "$(grep '^APP_KEY=base64:' .env)" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Создаем SQLite базу данных если её нет
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Устанавливаем права на директории
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Очищаем и кэшируем конфигурацию
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запускаем миграции
echo "Running migrations..."
php artisan migrate --force

echo "Starting application..."
exec "$@"

