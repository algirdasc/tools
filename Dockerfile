FROM php:8.2-apache

RUN a2enmod rewrite

RUN docker-php-ext install \
    mysqli

RUN docker-php-ext enable \
    mysqli

COPY . /var/www/html/

