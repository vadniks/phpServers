# run before on local machine
# php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# php composer-setup.php
# php -r "unlink('composer-setup.php');"
# ./composer.phar require mongodb/mongodb

FROM php:8.0-apache
WORKDIR /var/www/html-dynamic
RUN docker-php-ext-install mysqli
RUN pecl install redis && pecl install mongodb
RUN docker-php-ext-enable redis
RUN docker-php-ext-enable mongodb
COPY ports.conf /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY apache2.conf /etc/apache2/apache2.conf
COPY php.ini /usr/local/etc/php/php.ini
RUN a2enmod authn_dbd && apt-get update && apt-get install -y apache2-utils libaprutil1-dbd-mysql git
COPY vendor /var/www/vendor
RUN mkdir /var/www/files
RUN chmod 777 /var/www/files
EXPOSE 8081
