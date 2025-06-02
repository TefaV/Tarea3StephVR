FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring gd

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia primero composer.json y composer.lock (si existen)
COPY composer.json composer.lock* ./

# Ejecuta composer install solo si composer.json está presente
RUN if [ -f composer.json ]; then \
      COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader; \
    fi

# Copia el resto de los archivos
COPY . .

# Crea archivo SQLite y da permisos necesarios
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chmod -R 777 database database/database.sqlite storage bootstrap/cache

# Copia .env de ejemplo si no hay uno (Render usa variables de entorno)
RUN cp .env.example .env || true

# Genera APP_KEY si no existe
RUN php artisan key:generate || true

# Configura Apache para servir Laravel desde /public
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Habilita mod_rewrite y headers
RUN a2enmod rewrite headers

EXPOSE 80

CMD ["apache2-foreground"]
