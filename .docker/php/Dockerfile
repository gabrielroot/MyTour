# ============================================
# Stage 1: PHP Extensions Builder (shared with prod)
# ============================================
FROM php:8.2-fpm-alpine AS php-extensions

# Install build dependencies and compile extensions
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxslt-dev \
    linux-headers \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        xsl \
        gd \
        intl \
        opcache \
        exif \
        mbstring \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*

# ============================================
# Stage 2: Development Runtime
# ============================================
FROM php:8.2-fpm-alpine AS development
ARG TIMEZONE=America/Sao_Paulo

# Install runtime dependencies + dev tools
RUN apk add --no-cache \
    libzip \
    freetype \
    libpng \
    libjpeg-turbo \
    icu-libs \
    oniguruma \
    libxslt \
    fcgi \
    tzdata \
    git \
    unzip \
    bash \
    shadow \
    su-exec \
    nodejs \
    npm \
    && npm install -g yarn \
    && rm -rf /var/cache/apk/* /tmp/*

# Copy pre-built PHP extensions from builder stage
COPY --from=php-extensions /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=php-extensions /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n' "${TIMEZONE}" > /usr/local/etc/php/conf.d/tzone.ini

# Copy PHP configuration files
COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Xdebug configuration for development
RUN echo "[xdebug]" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=develop,debug,coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && touch /var/log/xdebug.log && chmod 666 /var/log/xdebug.log

# Copy healthcheck script
COPY php-fpm-healthcheck /usr/local/bin/php-fpm-healthcheck
RUN chmod +x /usr/local/bin/php-fpm-healthcheck

WORKDIR /var/www/symfony

# Create necessary directories
RUN mkdir -p var/cache var/log vendor public/build

# Copy entrypoint script
COPY entrypoint.dev.sh /usr/local/bin/entrypoint.dev.sh
RUN chmod +x /usr/local/bin/entrypoint.dev.sh

# Environment variables for development
ENV APP_ENV=dev
ENV APP_DEBUG=1
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV HOST_UID=1000
ENV HOST_GID=1000

ENTRYPOINT ["/usr/local/bin/entrypoint.dev.sh"]

CMD ["php-fpm"]
