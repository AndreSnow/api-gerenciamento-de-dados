FROM wyveo/nginx-php-fpm:latest


RUN apt-get upgrade -y && \
    apt-get update -y --fix-missing && \
    apt-get install -y apt-utils && \
    apt-get install -y \
    libmcrypt-dev \
    zlib1g-dev \
    libzip-dev \
    curl gnupg && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install

RUN chmod -R 775 storage/*

RUN php artisan cache:clear

EXPOSE 80