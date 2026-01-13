# Docker Setup for HursitV2

This directory contains Docker configuration files for running the HursitV2 Laravel application.

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
- `docker/nginx/nginx.conf` - Nginx main configuration
- `docker/nginx/default.conf` - Laravel site configuration
- `docker/supervisor/supervisord.conf` - Supervisor process manager configuration

## Volumes

The following directories are mounted as volumes for data persistence:
- `./storage` - Laravel storage directory
- `./database` - SQLite database file
- `./.env` - Environment configuration

## Ports

- Port 80: Web server (Nginx)

## Notes

- The application runs in production mode by default
- SQLite is used as the database
- Both PHP-FPM and Nginx run in a single container managed by Supervisor
- Frontend assets are built during the Docker image build process
