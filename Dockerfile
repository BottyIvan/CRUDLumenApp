FROM php:8.2-cli

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Install PHP dependencies using Composer
COPY composer.json composer.lock ./
RUN composer install

# Create storage directories and set permissions
RUN mkdir -p /var/www/storage/logs && chmod -R 775 /var/www/storage

# Command to run the application
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
