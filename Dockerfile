FROM php:7.2-apache

RUN a2enmod rewrite \
    && apt-get update \
    && apt-get install -y libpq-dev zip unzip \
    && docker-php-ext-install pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN service apache2 restart