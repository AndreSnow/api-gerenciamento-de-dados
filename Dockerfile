FROM php:8.1.0-apache

RUN apt-get upgrade -y && \
    apt-get update -y --fix-missing && \
    apt-get install -y apt-utils && \
    apt-get install -y \
    libmcrypt-dev \
    zlib1g-dev \
    libzip-dev \
    curl gnupg && \
    pecl install mcrypt-1.0.5 && \
    docker-php-ext-enable mcrypt && \
    docker-php-ext-install zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    docker-php-ext-install pdo pdo_mysql

RUN pecl install redis && docker-php-ext-enable redis

COPY . /var/www/html 

COPY php.ini /usr/local/etc/php/php.ini
COPY default.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html

RUN chmod 777 storage/* && \
    chmod 777 ./script.sh && \
    chmod 777 database && \
    chmod 777 database/database.sqlite

RUN a2enmod rewrite headers ssl && \
    service apache2 restart

# ENTRYPOINT ./script.sh ; /bin/bash

RUN php artisan config:clear

EXPOSE 80
# EXPOSE 443
