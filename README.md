# HursitV2

[![Coverage Status](https://coveralls.io/repos/github/hemreduru/hursitv2/badge.svg?branch=main)](https://coveralls.io/github/hemreduru/hursitv2?branch=main)

## Project Overview
Laravel project with comprehensive testing suite.

## Testing
Run tests locally:
```bash
php artisan test
```

## Upload Storage
Upload API uses `FILESYSTEM_UPLOADS_DISK` (default `s3`).
Set AWS credentials in `.env` (`AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, optional `AWS_URL` / `AWS_ENDPOINT`).

## CI/CD
Coverage reports are automatically sent to Coveralls on push to `main`.
