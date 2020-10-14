FROM php:7-fpm

RUN apt-get update &&\
    apt-get install -y iputils-ping telnet git zip mc &&\
    apt-get install -y libssl-dev zlib1g-dev libicu-dev libzip-dev

RUN docker-php-ext-install intl &&\
    docker-php-ext-install zip &&\
    docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN curl -s https://getcomposer.org/installer | php &&\
    mv composer.phar /usr/local/bin/composer
