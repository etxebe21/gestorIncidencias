# Usa la imagen oficial de PHP con FPM y las extensiones necesarias
FROM php:8.1-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el código de la aplicación
WORKDIR /var/www
COPY app/ ./


# Crea el directorio storage si no existe y establece permisos
RUN mkdir -p /var/www/storage && \
    chown -R www-data:www-data /var/www/storage && \
    chmod -R 775 /var/www/storage

# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000
