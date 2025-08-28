#!/bin/bash

# Exit on any error
set -e

echo "Starting Laravel application..."

# Create .env file from env-production.txt if it doesn't exist
if [ ! -f /var/www/html/.env ]; then
    echo "Creating .env file from env-production.txt..."
    cp /var/www/html/env-production.txt /var/www/html/.env
fi

# Ensure .env file has correct permissions
chown www-data:www-data /var/www/html/.env
chmod 644 /var/www/html/.env

# Set APP_KEY for production
echo "Setting APP_KEY for production..."
export APP_KEY="base64:ko3dW4IMQqhA5Y8RiFZqref/ahOasL6jbZLOKMCO9kk="

# Auto-detect and set APP_URL
if [ -z "$APP_URL" ] || [[ "$APP_URL" == *"schoolapplication-entity-"* ]]; then
    echo "Auto-detecting APP_URL..."
    # Get the current hostname from environment
    if [ ! -z "$RENDER_EXTERNAL_HOSTNAME" ]; then
        export APP_URL="https://$RENDER_EXTERNAL_HOSTNAME"
        echo "Set APP_URL to: $APP_URL"
        # Update .env file with the detected URL
        sed -i "s|APP_URL=.*|APP_URL=$APP_URL|" /var/www/html/.env
    fi
fi

# Set additional environment variables for production
echo "Setting production environment variables..."
export APP_ENV=production
export APP_DEBUG=false
export LOG_LEVEL=error

# Update .env file with production settings
sed -i "s|APP_ENV=.*|APP_ENV=production|" /var/www/html/.env
sed -i "s|APP_DEBUG=.*|APP_DEBUG=false|" /var/www/html/.env

# Export environment variables from .env file
echo "Exporting environment variables..."
set -a
source /var/www/html/.env
set +a

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

# Build assets for production
echo "Building frontend assets..."
npm run build

# Run Laravel migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."

# Run database seeders
echo "Running database seeders..."
php artisan db:seed --force || echo "Seeding failed, continuing..."

# Clear all caches to ensure fresh start
echo "Clearing all caches..."
php artisan optimize:clear || echo "Cache clear failed, continuing..."

# Create storage link
echo "Creating storage link..."
php artisan storage:link || echo "Storage link failed, continuing..."

# Ensure environment is properly loaded
echo "Ensuring environment is properly loaded..."
php artisan config:clear || echo "Config clear failed, continuing..."

# Test environment loading
echo "Testing environment configuration..."
php artisan env || echo "Environment test failed, continuing..."

# Verify .env file exists and is readable
echo "Verifying .env file..."
if [ -f /var/www/html/.env ]; then
    echo ".env file exists and contains:"
    head -5 /var/www/html/.env
else
    echo "ERROR: .env file does not exist!"
    exit 1
fi



# Clear and cache configuration
echo "Caching configuration..."
php artisan config:cache || echo "Config cache failed, continuing..."
php artisan route:cache || echo "Route cache failed, continuing..."
php artisan view:cache || echo "View cache failed, continuing..."

echo "Starting Apache..."
# Start Apache
apache2-foreground
