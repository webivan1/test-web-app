FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libpq-dev \
        zlib1g-dev \
        libicu-dev \
        g++

RUN docker-php-ext-configure intl
RUN docker-php-ext-install bcmath pcntl pdo pdo_mysql intl

WORKDIR /app
