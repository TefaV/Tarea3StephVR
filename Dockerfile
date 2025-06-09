FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_sqlite mbstring gd

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos necesarios de Composer y descarga dependencias
COPY composer.json composer.lock* ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Copia el resto del proyecto
COPY . .

# Crea archivo SQLite y asegura permisos
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chmod -R 777 database database/database.sqlite storage bootstrap/cache

# Configura Apache para servir Laravel desde /public
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Habilita módulos necesarios de Apache
RUN a2enmod rewrite headers

# Expone el puerto 80
EXPOSE 80

# Comando por defecto al iniciar el contenedor
CMD ["apache2-foreground"]
