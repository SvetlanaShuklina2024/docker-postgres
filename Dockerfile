FROM php:7.0.30-apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pgsql pdo pdo_pgsql
