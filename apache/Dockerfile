FROM php:7.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

RUN service apache2 restart