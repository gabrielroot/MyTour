#!/bin/sh
set -e

# Fix permissions for var/ directory (cache, logs, sessions)
if [ -d /var/www/symfony/var ]; then
    chown -R www:www /var/www/symfony/var 2>/dev/null || true
    chmod -R 777 /var/www/symfony/var 2>/dev/null || true
fi

# Fix permissions for public/ directory (assets)
if [ -d /var/www/symfony/public ]; then
    chown -R www:www /var/www/symfony/public 2>/dev/null || true
    chmod -R 775 /var/www/symfony/public 2>/dev/null || true
fi

#php bin/console d:m:migrate -n

# Execute the main container command (e.g., php-fpm)
exec "$@"

