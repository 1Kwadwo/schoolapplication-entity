# Use PHP 8.2 with Apache - proven stable version
FROM php:8.2-apache

# Install system dependencies in a single RUN command to reduce layers
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    ca-certificates \
    gnupg \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js using the official method
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install only the essential PHP extensions that Laravel actually needs
RUN docker-php-ext-install mbstring pdo pdo_sqlite zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy package files for Node.js
COPY package.json package-lock.json ./

# Install Node.js dependencies
RUN npm ci --production=false --no-audit --no-fund

# Copy the rest of the application
COPY . .

# Set proper ownership
RUN chown -R www-data:www-data /var/www/html

# Build frontend assets
RUN npm run build

# Create SQLite database file
RUN touch /var/www/html/database/database.sqlite

# Set proper permissions
RUN chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Configure Apache
RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Create startup script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Expose port 80
EXPOSE 80

# Start the application
CMD ["/start.sh"]
