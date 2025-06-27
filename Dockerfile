FROM composer:2 as build

FROM php:8.4-apache

COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY --from=build /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt upgrade -y && apt-get install -y libpq-dev unzip vim \
  && pecl install redis \
  && docker-php-ext-install pdo_pgsql && docker-php-ext-enable redis

