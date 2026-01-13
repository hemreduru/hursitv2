# HursitV2

[![Coverage Status](https://coveralls.io/repos/github/hemreduru/hursitv2/badge.svg?branch=main)](https://coveralls.io/github/hemreduru/hursitv2?branch=main)

## Project Overview
Laravel project with comprehensive testing suite.

## Docker Setup (LAMP Stack)

This project includes Docker support with LAMP stack (Linux, Apache, MySQL, PHP).

### Quick Start with Docker

**Option 1: Using the setup script (Recommended)**

```bash
git clone https://github.com/hemreduru/hursitv2.git
cd hursitv2
./docker-setup.sh
```

The script will automatically:
- Create `.env` file from `.env.example`
- Build and start Docker containers
- Generate application key
- Run database migrations

**Option 2: Manual setup**

1. Clone the repository:
```bash
git clone https://github.com/hemreduru/hursitv2.git
cd hursitv2
```

2. Copy the environment file:
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

6. Run database migrations:
```bash
docker-compose exec app php artisan migrate --force
```

7. Access the application at `http://localhost`

### Docker Commands

- **Stop containers**: `docker-compose down`
- **View app logs**: `docker-compose logs -f app`
- **View MySQL logs**: `docker-compose logs -f mysql`
- **Access app container**: `docker-compose exec app bash`
- **Access MySQL**: `docker-compose exec mysql mysql -u hursitv2_user -p hursitv2`
- **Run artisan commands**: `docker-compose exec app php artisan <command>`

For more detailed Docker documentation, see [docker/README.md](docker/README.md).

## Testing
Run tests locally:
```bash
php artisan test
```

## CI/CD
Coverage reports are automatically sent to Coveralls on push to `main`.
