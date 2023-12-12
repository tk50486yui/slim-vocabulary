FROM php:7.2-apache

RUN a2enmod rewrite \
    && apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && service apache2 restart