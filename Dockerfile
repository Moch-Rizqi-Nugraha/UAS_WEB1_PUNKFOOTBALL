FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y git zip unzip libzip-dev zlib1g-dev libpng-dev libonig-dev libxml2-dev curl \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip

# Install Composer (copy from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

RUN composer install --no-dev --prefer-dist --optimize-autoloader || true

EXPOSE 9000
CMD ["php-fpm"]
