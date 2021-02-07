ARG php_version=7.1
FROM php:${php_version}-cli

LABEL maintainer="Ryan Gellis <ryan.gellis@rmgmedia.com>"

RUN apt-get update && apt-get install -y \
  cron \
  libfreetype6-dev \
  libjpeg-dev \
#  libmcrypt-dev \
  libzip-dev \
  libpng-dev \
  libxml2-dev \
  libxslt-dev \
  zlib1g-dev \
#  && pecl install redis \
#  && pecl install mcrypt-1.0.3 \
#  && docker-php-ext-enable redis \
#  && docker-php-ext-enable mcrypt \
  && docker-php-ext-install bcmath \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/lib \
  && docker-php-ext-install gd \
  && docker-php-ext-install intl \
#  && docker-php-ext-install openssl \
#  && docker-php-ext-install mcrypt \
  && docker-php-ext-install opcache \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install soap \
  && docker-php-ext-install xsl \
  && docker-php-ext-install zip \
  && docker-php-ext-install sockets \
&& rm -rf /var/lib/apt/lists/*

COPY ./docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www/magento

ENTRYPOINT ["docker-entrypoint.sh"]
