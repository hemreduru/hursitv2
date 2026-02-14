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
Upload API uses `FILESYSTEM_UPLOADS_DISK` (default `public`).
Default local path is `storage/app/public/uploads` and public URL requires `php artisan storage:link`.
S3 can still be used optionally by setting `FILESYSTEM_UPLOADS_DISK=s3` and providing `AWS_*` credentials.

## CI/CD
Coverage reports are automatically sent to Coveralls on push to `main`.
