# Use official PHP 8.4 image with FPM
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./

# Install Laravel dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Copy PHP configuration files
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy and configure entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create required directories and set permissions
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Post-install composer optimization
RUN composer dump-autoload --optimize

# Expose PHP-FPM port
EXPOSE 9000

# Entrypoint for initialization
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
