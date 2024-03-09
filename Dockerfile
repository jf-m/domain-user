FROM php:8.2

ARG XDEBUG_VERSION=3.3.1

RUN pecl install xdebug-${XDEBUG_VERSION}
RUN docker-php-ext-enable xdebug

RUN echo "xdebug.mode=${XDEBUG_MODE}" > $PHP_INI_DIR/conf.d/xdebug.ini
RUN echo "xdebug.mode=coverage" >> $PHP_INI_DIR/conf.d/xdebug.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
