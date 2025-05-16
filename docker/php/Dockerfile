FROM php:8.2-fpm

# Install dependencies sistem dan ekstensi PHP yang diperlukan Laravel
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nano procps default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer (copy dari official composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy source Laravel app
COPY ./app /var/www

# Copy skrip wait-for-mysql dan berikan permission executable
COPY ./docker/wait-for-mysql.sh /wait-for-mysql.sh
RUN chmod +x /wait-for-mysql.sh

# Install dependencies Laravel via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permission agar user www-data bisa akses
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose port php-fpm (default 9000)
EXPOSE 9000
