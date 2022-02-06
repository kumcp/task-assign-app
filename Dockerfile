FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www

WORKDIR /var/www

RUN chmod -R 777 /var/www/storage
