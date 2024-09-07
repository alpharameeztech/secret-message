#!/bin/sh

# Wait for the database to be ready
echo "Waiting for database to be ready..."
while ! nc -z db 3306; do
  sleep 1
done

# Check if .env file exists, if not, create it
if [ ! -f ".env" ]; then
  echo "Creating .env file from .env.example..."
  cp .env.example .env
fi

# Ensure that MySQL is being used in the .env file
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
sed -i 's/DB_PORT=.*/DB_PORT=3306/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

# Install Composer dependencies before generating the application key
if [ ! -d "vendor" ]; then
  echo "Installing Composer dependencies..."
  composer install
fi

# Check if APP_KEY is not set, then generate the key
if [ -z "$(grep 'APP_KEY=' .env | cut -d '=' -f2)" ]; then
  echo "Generating application key..."
  php artisan key:generate

  # Output the contents of the .env file to verify the key is set
  echo "Contents of .env after key generation:"
  cat .env
fi

# Install npm dependencies if they don't exist
if [ ! -d "node_modules" ]; then
  echo "Installing npm dependencies..."
  npm install
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force

# Start Vite development server if in local environment
if [ "$APP_ENV" = "local" ]; then
    echo "Starting Vite development server..."
    npm run dev &
fi

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
