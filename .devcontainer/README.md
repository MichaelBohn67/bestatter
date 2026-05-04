# Devcontainer

This folder contains a Docker Compose-based Laravel Development Container setup.

## Included
- App container (PHP 8.2 + Composer + Node.js 20)
- MariaDB service (`db`)
- Redis service (`redis`)
- sqlite dependencies for test workflows

## First start
On container creation, `.devcontainer/post-create.sh` runs automatically and performs:
- `composer install`
- `npm install`
- `.env.devcontainer` creation from `.env.example` with `mysql` + `redis` defaults
- `.env` creation from `.env.devcontainer` (if missing)
- `php artisan key:generate`
- `database/database.sqlite` creation

On each container start, `.devcontainer/post-start.sh` runs automatically and performs:
- `php artisan migrate --force` (with retry loop while DB boots)
- Runs only when `APP_ENV=local`

## Environment defaults
The generated `.env.devcontainer` config points to:
- `DB_HOST=db`
- `DB_DATABASE=bestatter`
- `DB_USERNAME=bestatter`
- `DB_PASSWORD=bestatter`
- `REDIS_HOST=redis`

If you already have a custom `.env`, it is not overwritten.

Set `SKIP_DEVCONTAINER_MIGRATIONS=1` if you want to skip auto-migration on startup.

## Daily commands
```bash
composer run dev
composer run test
```
