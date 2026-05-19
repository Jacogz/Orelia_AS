FROM php:8.3.11-apache

RUN apt-get update -y && apt-get install -y openssl zip unzip git

RUN docker-php-ext-install pdo_sqlite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html
COPY ./public/.htaccess /var/www/html/.htaccess
WORKDIR /var/www/html

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

RUN touch /var/www/html/database/database.sqlite

RUN php artisan key:generate
RUN php artisan migrate --seed

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/database \
 && chmod -R 775 /var/www/html/storage /var/www/html/database

RUN a2enmod rewrite
