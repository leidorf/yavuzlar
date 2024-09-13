FROM php:apache
RUN apt-get update && docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html
WORKDIR /var/www/html