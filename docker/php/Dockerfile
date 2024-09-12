FROM php:8.3-cli

# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql

RUN docker-php-ext-install pcntl
RUN docker-php-ext-configure pcntl --enable-pcntl

RUN pecl install xdebug pcov \
    && docker-php-ext-enable xdebug

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/scripts/install-app.sh /usr/local/bin/install-app
COPY ./docker/php/xdebug.ini /etc/php/8.3/mods-available/xdebug.ini

# Exponhe a porta 9000 para o servidor PHP-FPM
EXPOSE 8000

# Inicia o servidor PHP-FPM
CMD ["/usr/local/bin/install-app"]
