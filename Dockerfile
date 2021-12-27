FROM php:7.4-fpm

COPY . /var/www

WORKDIR /var/www

RUN chmod -R 777 /var/www/storage
# CMD [ "php", "./your-script.php" ]