#!/bin/bash

# Exit on any error
set -e

echo "Starting Laravel application..."

# Set simple APP_KEY for offline project
echo "Setting simple APP_KEY for offline project..."
export APP_KEY="base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA="

# Auto-detect and set APP_URL
if [ -z "$APP_URL" ] || [[ "$APP_URL" == *"schoolapplication-entity-"* ]]; then
    echo "Auto-detecting APP_URL..."
    # Get the current hostname from environment
    if [ ! -z "$RENDER_EXTERNAL_HOSTNAME" ]; then
        export APP_URL="https://$RENDER_EXTERNAL_HOSTNAME"
        echo "Set APP_URL to: $APP_URL"
    fi
fi

# Create necessary directories if they don't exist
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Run Laravel migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."

# Create storage link
echo "Creating storage link..."
php artisan storage:link || echo "Storage link failed, continuing..."

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:cache || echo "Config cache failed, continuing..."
php artisan route:cache || echo "Route cache failed, continuing..."
php artisan view:cache || echo "View cache failed, continuing..."

echo "Starting Apache..."
# Start Apache
apache2-foreground
