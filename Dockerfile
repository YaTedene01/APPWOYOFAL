FROM php:8.2-fpm

WORKDIR /var/www/html

# Install PostgreSQL extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy entire project
COPY . .

# Verify bootstrap.php exists and set permissions
RUN ls -la /var/www/html/config/bootstrap.php || echo "bootstrap.php not found" && \
    chown -R www-data:www-data /var/www/html