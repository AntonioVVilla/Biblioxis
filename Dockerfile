FROM php:8.2-fpm

# Instalar dependencias del sistema y Node.js (opcional, útil para npm build)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    gnupg \
    ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar extensión Redis para PHP
RUN pecl install redis && docker-php-ext-enable redis

# Limpiar caché de APT
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copiar Composer desde contenedor oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar archivos de la aplicación
COPY . /var/www

# Instalar dependencias de Composer
RUN composer install --no-interaction --no-plugins --no-scripts

# Permisos necesarios para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer puerto interno del contenedor PHP-FPM
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]
