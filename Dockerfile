# Use the official PHP image as the base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    nodejs \
    npm \
    netcat-openbsd

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy the current directory contents into the container
COPY . .

# Install application dependencies (PHP)
RUN composer install

# Install npm dependencies (Node.js for Vite)
RUN npm install

# Copy the entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Make the entrypoint script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port 9000 for PHP-FPM and port 5173 for Vite
EXPOSE 9000 5173

# Set the entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
