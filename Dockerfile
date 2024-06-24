FROM php:8.2.0-fpm
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_SECRET=6f0587de3a80a2929188b4359b3ede0c
RUN apt-get update && apt-get install -y \
git \
unzip \
libzip-dev \
zlib1g-dev \
libicu-dev \
libxml2-dev \
&& docker-php-ext-install zip intl xml
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
COPY composer.json composer.lock ./
RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN composer install --no-scripts --no-autoloader
COPY . .
RUN chown -R www-data:www-data .
EXPOSE 8000
CMD symfony serve