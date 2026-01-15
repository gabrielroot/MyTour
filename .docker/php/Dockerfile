FROM php:8.2-fpm
ARG TIMEZONE=America/Sao_Paulo

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    curl \
    && rm -rf /var/lib/apt/lists/* \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n' "${TIMEZONE}" > /usr/local/etc/php/conf.d/tzone.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and Yarn for asset building
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn \
    && rm -rf /var/lib/apt/lists/*

# Create non-root user
RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www/symfony

# Ensure runtime dirs exist with correct permissions
RUN mkdir -p /var/www/symfony/var/cache \
    /var/www/symfony/var/log \
    /var/www/symfony/vendor \
    /var/www/symfony/public/build \
    && chown -R www:www /var/www/symfony \
    && chmod -R 777 /var/www/symfony/var

# Install PHP dependencies (no-dev for prod, no-scripts to avoid dev-only errors)
RUN composer install \
    --no-interaction

# Change current user to www
USER www
