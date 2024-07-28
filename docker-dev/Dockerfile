ARG PHP_VERSION="8.2"

FROM php:${PHP_VERSION}-fpm

RUN apt-get update && apt-get -y --no-install-recommends install \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libgd-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    zip \
    libzip-dev \
    libpq-dev \
    unzip \
    supervisor \
    tzdata \
    && apt-get autoremove --purge -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini

ENV TZ="Asia/Jakarta"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

#RUN docker-php-ext-configure zip --with-libzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) \
    opcache \
    intl \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    pdo \
    pdo_pgsql \
    zip

#RUN pecl install apcu-5.1.20 && docker-php-ext-enable apcu

COPY docker-dev/app/php.ini   $PHP_INI_DIR/conf.d/

RUN curl -sS https://getcomposer.org/installer | \
php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app

COPY . /var/www/app

RUN composer update --no-dev

#RUN composer update
ADD docker-dev/app/supervisor.conf /etc/supervisor/conf.d/worker.conf

EXPOSE 9000
