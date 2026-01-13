# Docker Setup for HursitV2

This directory contains Docker configuration files for running the HursitV2 Laravel application with LAMP stack (Linux, Apache, MySQL/SQLite, PHP).

## Prerequisites

- Docker
- Docker Compose

## Quick Start

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your environment variables:
   ```bash
   cp .env.example .env
   ```

3. Build and start the containers:
   ```bash
   docker-compose up -d --build
   ```

4. Create SQLite database file:
   ```bash
   docker-compose exec app touch /var/www/html/database/database.sqlite
   docker-compose exec app chown www-data:www-data /var/www/html/database/database.sqlite
   ```

5. Generate application key:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. Run migrations:
   ```bash
   docker-compose exec app php artisan migrate --force
   ```

7. Access the application at `http://localhost`

## Docker Commands

### Build and start containers
```bash
docker-compose up -d --build
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f app
```

### Access container shell
```bash
docker-compose exec app bash
```

### Run artisan commands
```bash
docker-compose exec app php artisan <command>
```

### Run composer commands
```bash
docker-compose exec app composer <command>
```

## Configuration Files

- `Dockerfile` - Main Docker image configuration
- `docker-compose.yml` - Docker Compose orchestration
- `docker/apache/laravel.conf` - Apache virtual host configuration for Laravel
- `docker/supervisor/supervisord.conf` - Supervisor process manager configuration

## Volumes

The following directories are mounted as volumes for data persistence:
- `./storage` - Laravel storage directory
- `./database` - SQLite database file
- `./.env` - Environment configuration

## Ports

- Port 80: Web server (Apache)

## LAMP Stack Components

- **L**inux: Debian (from PHP base image)
- **A**pache: Apache 2.4 with mod_php
- **M**ySQL/SQLite: SQLite is used as the database
- **P**HP: PHP 8.2 with required extensions

## Notes

- The application runs in production mode by default
- SQLite is used as the database
- Apache runs with mod_php (not PHP-FPM)
- Apache is managed by Supervisor for process monitoring
- Frontend assets are built during the Docker image build process
- Apache mod_rewrite is enabled for Laravel routing
