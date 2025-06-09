FROM php:8.2-apache

# Instala dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring gd

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece directorio
WORKDIR /var/www/html

# Copia composer y descarga dependencias
COPY composer.json composer.lock* ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Copia el resto del proyecto
COPY . .

# Asegura permisos y base de datos SQLite
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chmod -R 777 database database/database.sqlite storage bootstrap/cache

# Configura Apache
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Habilita rewrite
RUN a2enmod rewrite headers

EXPOSE 80

CMD ["apache2-foreground"]
