FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /var/www

COPY ./app /var/www
COPY ./app/.env.example /var/www/.env


RUN composer install --no-interaction --prefer-dist

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www 
