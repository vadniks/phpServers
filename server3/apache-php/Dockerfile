FROM php:8.0-apache
WORKDIR /var/www/html-dynamic
RUN docker-php-ext-install mysqli
COPY ports.conf /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 8081
