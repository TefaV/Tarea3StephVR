# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y libpng-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar primero composer.json y composer.lock para aprovechar la caché de Docker
COPY composer.json composer.lock ./

# Instalar dependencias de Laravel
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Copiar el resto del proyecto
COPY . .

# Crear archivo de base de datos SQLite si no existe
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chmod -R 777 database database/database.sqlite

# Dar permisos a storage y bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Copiar archivo .env de ejemplo si no existe uno real (Render usa variables de entorno)
RUN cp .env.example .env || true

# Generar APP_KEY automáticamente (necesario para que Laravel funcione)
RUN php artisan key:generate

# Configurar Apache para que sirva desde /public
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf \
    && echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf \
    && echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf \
    && echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf \
    && echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf \
    && echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf \
    && echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite y headers
RUN a2enmod rewrite headers

# Exponer puerto 80
EXPOSE 80

# Iniciar Apache en primer plano
CMD ["apache2-foreground"]
