#!/bin/bash

# HursitV2 Docker Setup Script
# This script helps set up the application with Docker

set -e

echo "==================================="
echo "HursitV2 Docker Setup"
echo "==================================="
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "Error: Docker is not installed. Please install Docker first."
    echo "Visit: https://docs.docker.com/get-docker/"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "Error: Docker Compose is not installed. Please install Docker Compose first."
    echo "Visit: https://docs.docker.com/compose/install/"
    exit 1
fi

# Copy .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    echo "✓ .env file created"
else
    echo "✓ .env file already exists"
fi

echo ""
echo "Building and starting Docker containers..."
docker-compose up -d --build

echo ""
echo "Waiting for MySQL to be ready..."
echo "This may take up to 30 seconds..."
sleep 10

# Wait for MySQL to be ready
until docker-compose exec -T mysql mysqladmin ping -h localhost --silent; do
    echo "Waiting for MySQL..."
    sleep 2
done

echo "✓ MySQL is ready!"

echo ""
echo "Generating application key..."
docker-compose exec -T app php artisan key:generate

echo ""
echo "Running database migrations..."
docker-compose exec -T app php artisan migrate --force

echo ""
echo "==================================="
echo "✓ Setup completed successfully!"
echo "==================================="
echo ""
echo "Your application is now running at: http://localhost"
echo ""
echo "Database Information:"
echo "  - Host: mysql (from app container) or localhost (from host)"
echo "  - Port: 3306"
echo "  - Database: hursitv2"
echo "  - Username: hursitv2_user"
echo "  - Password: hursitv2_password"
echo ""
echo "Useful commands:"
echo "  - View app logs: docker-compose logs -f app"
echo "  - View MySQL logs: docker-compose logs -f mysql"
echo "  - Stop containers: docker-compose down"
echo "  - Access app container: docker-compose exec app bash"
echo "  - Access MySQL: docker-compose exec mysql mysql -u hursitv2_user -p hursitv2"
echo "  - Run artisan: docker-compose exec app php artisan <command>"
echo ""
