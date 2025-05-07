# Gunakan image PHP resmi dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-fpm

# Install sistem package dan ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nano \
    libzip-dev \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Salin seluruh project Laravel (via docker-compose bind mount, akan ditimpa)
COPY ./app /var/www

# Set permission folder storage dan cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port untuk fpm (optional)
EXPOSE 9000

CMD ["php-fpm"]
