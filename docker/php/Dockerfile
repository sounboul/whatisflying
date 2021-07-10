FROM php:8.0-fpm

COPY config/php.ini /usr/local/etc/php/php.ini

RUN apt-get update && \
    apt-get install -y curl git libicu-dev libzip-dev nodejs unzip uuid-dev zlib1g-dev && \
    pecl install redis uuid && \
    docker-php-ext-install bcmath intl pdo pdo_mysql sysvsem zip && \
    docker-php-ext-enable redis uuid && \
    curl -Ss https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

ENV COMPOSER_ALLOW_SUPERUSER=1
