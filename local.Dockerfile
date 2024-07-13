FROM php:8.1.11-fpm-alpine3.16 as base-stage

ARG BUILD_TYPE=local

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    bash \
    git \
    zip \
    unzip \
    postgresql-dev \
    rabbitmq-c-dev \
    libpq

RUN apk add --no-cache libzip-dev && docker-php-ext-configure zip && docker-php-ext-install zip

RUN pecl install amqp-1.11.0beta && docker-php-ext-enable amqp

RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install bcmath
RUN docker-php-ext-enable sodium

# установка xdebug
#RUN pecl install xdebug-2.9.5 && docker-php-ext-enable xdebug
#RUN echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_port=9001 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_autostart=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_connect_back=0 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.idekey=PHP_STORM >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo xdebug.remote_host=host.docker.internal >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN rm -rf /var/cache/apk/*

FROM base-stage as composer-stage
# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /composer

COPY composer.json ./composer.lock ./symfony.lock ./

#RUN composer install --no-scripts -o -n --prefer-dist

FROM base-stage as app-stage

WORKDIR /var/www/html

COPY --from=composer-stage /composer .
COPY --from=composer-stage /usr/local/bin/composer /usr/local/bin/composer

COPY bin                        ./bin
COPY config                     ./config
COPY public                     ./public
COPY src                        ./src
#COPY translations               ./translations
COPY migrations                 ./migrations
#COPY templates                  ./templates
COPY tests                      ./tests
COPY .php-cs-fixer.dist.php     ./.php-cs-fixer.dist.php
COPY config/php/php_loc.ini     ./php_loc.ini

RUN cp php_loc.ini $PHP_INI_DIR/conf.d/php.override.ini

RUN mkdir -p var/cache var/log \
    && chmod -R 0777 var \
    && chmod +x bin/console \
    && touch .env

CMD ["php-fpm", "--nodaemonize"]
