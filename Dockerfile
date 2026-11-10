FROM php:8.2-cli

RUN apt-get update && apt-get install -y git unzip libsodium-dev \
    && docker-php-ext-install sodium \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV SESSION_DRIVER=file
ENV CACHE_STORE=file

EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}