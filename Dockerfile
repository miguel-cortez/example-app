# Imagen base para crear la imagen personalizada
FROM php:8.3-fpm-alpine

# Instalación de paquetes necesarios
RUN apk add --no-cache \
    bash \
    curl \
    unzip \
    git \
    zip \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    build-base \
    nodejs \
    npm \
    libzip-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS

# Instalación de extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && docker-php-source delete \
    && apk del .build-deps \
    && docker-php-ext-install zip

# Instalación de composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código de la aplicación al directorio /var/www de la imagen personalizada
WORKDIR /var/www
COPY . .

# Instalación de Composer (producción) y eliminación de archivos innecesarios
RUN composer install --optimize-autoloader --no-dev --prefer-source

# Compilación de Node.js y generación de código optimizado para producción
RUN npm install && npm run build

# Establecer permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Comandos de inicio de la aplicación Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]