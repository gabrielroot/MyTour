#!/bin/bash
set -e

# ============================================
# Dynamic user creation for matching host UID/GID
# This ensures files created in container are owned by host user
# ============================================
HOST_UID=${HOST_UID:-1000}
HOST_GID=${HOST_GID:-1000}

echo "🔧 Setting up user with UID:${HOST_UID} GID:${HOST_GID}"

# Create group if it doesn't exist
if ! getent group www > /dev/null 2>&1; then
    addgroup -g ${HOST_GID} www
elif [ "$(getent group www | cut -d: -f3)" != "${HOST_GID}" ]; then
    # Group exists but with different GID - recreate
    delgroup www 2>/dev/null || true
    addgroup -g ${HOST_GID} www
fi

# Create user if it doesn't exist
if ! getent passwd www > /dev/null 2>&1; then
    adduser -u ${HOST_UID} -G www -s /bin/bash -D www
elif [ "$(id -u www)" != "${HOST_UID}" ]; then
    # User exists but with different UID - recreate
    deluser www 2>/dev/null || true
    adduser -u ${HOST_UID} -G www -s /bin/bash -D www
fi

# Configure PHP-FPM to run as www user
sed -i "s/user = .*/user = www/g" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/group = .*/group = www/g" /usr/local/etc/php-fpm.d/www.conf

cd /var/www/symfony

# ============================================
# Fix ownership of var directory
# ============================================
mkdir -p var/cache/dev var/log 2>/dev/null || true
chown -R www:www var 2>/dev/null || true

# ============================================
# Install dependencies if not present (as www user)
# ============================================
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing Composer dependencies..."
    su-exec www composer install --no-interaction --prefer-dist
fi

if [ ! -d "node_modules" ]; then
    echo "📦 Installing Node.js dependencies..."
    su-exec www yarn install
fi

# ============================================
# Build assets in watch mode (background)
# ============================================
if [ -f "webpack.config.js" ]; then
    echo "🔨 Starting Webpack Encore in watch mode..."
    su-exec www yarn encore dev --watch &
fi

# ============================================
# Clear and warmup cache
# ============================================
if [ -d "var/cache/dev" ]; then
    echo "🧹 Clearing development cache..."
    rm -rf var/cache/dev/* 2>/dev/null || true
fi

# ============================================
# Run database migrations
# ============================================
echo "🗄️  Running database migrations..."
su-exec www php bin/console doctrine:migrations:migrate --no-interaction 2>/dev/null || true

# ============================================
# Warmup cache
# ============================================
echo "🔥 Warming up cache..."
su-exec www php bin/console cache:warmup --env=dev 2>/dev/null || true

echo "✅ Development environment ready!"

# Execute the main container command (php-fpm runs as configured user)
exec "$@"
