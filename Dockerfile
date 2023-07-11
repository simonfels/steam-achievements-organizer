FROM php:apache
RUN apt-get update \
    && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli bcmath
RUN a2enmod rewrite
WORKDIR /var/www/html
COPY html/ .
EXPOSE 80
