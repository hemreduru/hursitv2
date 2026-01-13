# Docker Setup for HursitV2

This directory contains Docker configuration files for running the HursitV2 Laravel application with LAMP stack (Linux, Apache, MySQL, PHP).

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

4. Wait for MySQL to be ready (about 10-30 seconds)

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
# Application logs
docker-compose logs -f app

# MySQL logs
docker-compose logs -f mysql
```

### Access container shell
```bash
# Access application container
docker-compose exec app bash

# Access MySQL
docker-compose exec mysql mysql -u hursitv2_user -p hursitv2
# Password: hursitv2_password
```

### Run artisan commands
```bash
docker-compose exec app php artisan <command>
```

### Run composer commands
```bash
docker-compose exec app composer <command>
```

### Database Management
```bash
# Access MySQL CLI
docker-compose exec mysql mysql -u root -p
# Root password: root_password

# Backup database
docker-compose exec mysql mysqldump -u hursitv2_user -p hursitv2 > backup.sql

# Restore database
docker-compose exec -T mysql mysql -u hursitv2_user -p hursitv2 < backup.sql
```

## Configuration Files

- `Dockerfile` - Main Docker image configuration
- `docker-compose.yml` - Docker Compose orchestration
- `docker/apache/laravel.conf` - Apache virtual host configuration for Laravel
- `docker/supervisor/supervisord.conf` - Supervisor process manager configuration

## Services

### App Service
- **Container**: hursitv2-app
- **Port**: 80
- **Web Server**: Apache 2.4 with mod_php
- **PHP**: 8.2

### MySQL Service
- **Container**: hursitv2-mysql
- **Port**: 3306 (internal)
- **Database**: hursitv2
- **Username**: hursitv2_user
- **Password**: hursitv2_password
- **Root Password**: root_password

## Volumes

The following are mounted as volumes for data persistence:
- `./storage` - Laravel storage directory
- `./.env` - Environment configuration
- `mysql_data` - MySQL data (Docker volume)

## Ports

- Port 80: Web server (Apache)
- Port 3306: MySQL (internal, not exposed to host by default)

## LAMP Stack Components

- **L**inux: Debian (from PHP base image)
- **A**pache: Apache 2.4 with mod_php
- **M**ySQL: MySQL 8.0
- **P**HP: PHP 8.2 with required extensions

## Notes

- The application runs in production mode by default
- MySQL 8.0 is used as the database with persistent storage
- Apache runs with mod_php (not PHP-FPM)
- Apache is managed by Supervisor for process monitoring
- Frontend assets are built during the Docker image build process
- Apache mod_rewrite is enabled for Laravel routing
- MySQL data persists in a Docker volume even when containers are removed

## Environment Variables

Key environment variables in docker-compose.yml:
- `DB_CONNECTION=mysql`
- `DB_HOST=mysql`
- `DB_PORT=3306`
- `DB_DATABASE=hursitv2`
- `DB_USERNAME=hursitv2_user`
- `DB_PASSWORD=hursitv2_password`

You can override these by editing your `.env` file or the docker-compose.yml file.
