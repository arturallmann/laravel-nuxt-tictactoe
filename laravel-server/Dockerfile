# select php image 
FROM php:alpine3.20
# select work directory
WORKDIR /var/www/html
# install composer to container
RUN apk update
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.4.3 --install-dir=/usr/local/bin --filename=composer
# copy laravel-server files to container and install dependencies
COPY . .
RUN composer install
# create .env file from .env.example
RUN mv .env.example .env
# run all migrations and create database
RUN php artisan migrate --force
# start app
CMD ["php","artisan","serve","--host=0.0.0.0"]
