#!/bin/sh

# Wait for the database to be ready
echo "Waiting for database to be ready..."
while ! nc -z db 3306; do
  sleep 1
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force

# Check if npm is installed
echo "Checking for npm..."
if command -v npm >/dev/null 2>&1; then
    echo "npm is installed."
else
    echo "npm is NOT installed."
fi

# Start Vite development server if in local environment
if [ "$APP_ENV" = "local" ]; then
    echo "Starting Vite development server..."
    npm run dev &
else
    echo "Not in local environment, skipping Vite."
fi

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
