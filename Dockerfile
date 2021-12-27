FROM php:7.4-fpm

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
# CMD [ "php", "./your-script.php" ]