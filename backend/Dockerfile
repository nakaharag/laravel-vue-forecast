FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/$(ls /usr/local/lib/php/extensions/ | grep no-debug-non-zts))/xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/c\<Directory \/var\/www\/html\/>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n<\/Directory>' /etc/apache2/apache2.conf

COPY ./composer.lock ./composer.json /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --no-autoloader

COPY . /​⬤
