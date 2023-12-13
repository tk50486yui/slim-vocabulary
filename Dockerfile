FROM php:7.2-apache

COPY . /var/www/html

WORKDIR /var/www/html

RUN a2enmod rewrite \
    && apt-get update \
    && apt-get install -y libpq-dev zip unzip \
    && docker-php-ext-install pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.5.4

RUN chown www-data:www-data /var/www/html -R

RUN composer install \
    && composer dump-autoload \
    && service apache2 restart