# ─────────────────────────────────────────────
# Orelia AS — Laravel 12 + Apache + SQLite
# ─────────────────────────────────────────────
FROM debian:12

ENV DEBIAN_FRONTEND=noninteractive

# ── 1. Dependencias base
RUN apt-get update -y && \
    apt-get install -y \
        apt-transport-https \
        lsb-release \
        ca-certificates \
        curl \
        wget \
        git \
        apache2 \
        unzip \
        nano

# ── 2. Repositorio PHP 8.4 (sury.org)
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" \
        > /etc/apt/sources.list.d/php.list' && \
    apt-get update

# ── 3. PHP 8.4 y extensiones
RUN apt-get install -y \
        php8.4 \
        php8.4-cli \
        libapache2-mod-php8.4 \
        php8.4-sqlite3 \
        php8.4-mbstring \
        php8.4-xml \
        php8.4-zip \
        php8.4-curl

# ── 4. Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

# ── 5. mod_rewrite
RUN a2enmod rewrite

# ── 6. Clonar repositorio
ARG REPO_URL=https://github.com/Jacogz/Orelia_AS.git

WORKDIR /var/www/html
RUN git clone ${REPO_URL}

# ── 7. Instalar dependencias Laravel
WORKDIR /var/www/html/Orelia_AS/orelia_project
RUN composer install --no-interaction

# ── 8. Permisos de escritura
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 777 storage && \
    chmod -R 777 database

# ── 9. Entorno, clave y base de datos
RUN cp .env.example .env && \
    php artisan key:generate

RUN touch database/database.sqlite && \
    chmod 777 database/database.sqlite && \
    php artisan migrate --seed --force

# ── 10. Symlink de storage (imágenes subidas)
RUN php artisan storage:link

# ── 11. VirtualHost de Apache
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/Orelia_AS/orelia_project/public\n\
    <Directory /var/www/html/Orelia_AS/orelia_project/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog \${APACHE_LOG_DIR}/laravel_error.log\n\
    CustomLog \${APACHE_LOG_DIR}/laravel_access.log combined\n\
</VirtualHost>" > /etc/apache2/sites-available/laravel.conf && \
    a2ensite laravel.conf && \
    a2dissite 000-default.conf

EXPOSE 80

# ── 12. Apache en foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
