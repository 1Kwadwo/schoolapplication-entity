#!/bin/bash

# Wait for database to be ready (if using external database)
# sleep 10

# Run Laravel migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Start Apache
apache2-foreground
