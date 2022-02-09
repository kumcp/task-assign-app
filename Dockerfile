FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

# Copy the current project
COPY . /var/www

WORKDIR /var/www

# Move all the current .env.example to .env
# All other env variables will be defined in docker-compose.yml

RUN cp /var/www/.env.example /var/www/.env

RUN chmod -R 777 /var/www/storage
