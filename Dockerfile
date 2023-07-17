FROM php:apache
RUN apt-get update \
    && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli bcmath
RUN a2enmod rewrite
WORKDIR /var/www
COPY public_html/ /html
COPY src/ /src
EXPOSE 80
