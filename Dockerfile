# Usa una imagen oficial de PHP con Apache
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

# Copia archivos composer para usar caché
COPY composer.json composer.lock* ./

# Instala dependencias sin scripts (evita errores de producción)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-scripts

# Copia todo el proyecto
COPY . .

# Prepara SQLite y permisos necesarios
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chmod -R 777 database database/database.sqlite storage bootstrap/cache

# Copia .env si no existe
RUN cp .env.example .env || true

# Genera clave de aplicación (Render requiere que la guardes en el panel)
RUN php artisan key:generate || true

# Configura Apache para servir desde /public
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Habilita mod_rewrite y headers
RUN a2enmod rewrite headers

# Expone el puerto web
EXPOSE 80

# Inicia Apache
CMD ["apache2-foreground"]
