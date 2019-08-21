FROM php:7.2-fpm

RUN apt update && apt install -y \
    git \
    openssh-client \
    unzip \
    --no-install-recommends && rm -r /var/lib/apt/lists/*

WORKDIR /app

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo_mysql mysqli opcache && \
    docker-php-ext-enable pdo_mysql mysqli opcache

COPY composer.* ./

ENV COMPOSER_VERSION 1.9.0

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') \
        { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} && \
    php -r "unlink('composer-setup.php');" && \
    composer install --no-scripts --no-autoloader --no-interaction

COPY . ./

RUN chgrp -R www-data storage bootstrap/cache && chmod -R ug+rwx storage bootstrap/cache && \
    composer dump-autoload --optimize

