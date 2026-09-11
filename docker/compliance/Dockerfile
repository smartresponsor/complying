# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \    git \    unzip \    libpq-dev \    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/app

COPY . /var/www/app

RUN php -v

EXPOSE 9000

CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]
