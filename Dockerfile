# Image PHP officielle
FROM php:8.2-fpm-alpine

# Extensions PHP dont Laravel a besoin
RUN apk add --no-cache \
    git curl zip unzip \
    libpng-dev libjpeg-turbo-dev libwebp-dev \
    libzip-dev icu-dev oniguruma-dev

RUN docker-php-ext-configure gd --with-jpeg --with-webp
RUN docker-php-ext-install gd pdo pdo_mysql intl mbstring zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier l'application
WORKDIR /var/www
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Lier le dossier public/storage
RUN php artisan storage:link || true

# Démarrer Laravel
CMD php artisan serve --host 0.0.0.0 --port 8080
