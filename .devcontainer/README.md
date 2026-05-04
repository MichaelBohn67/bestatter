# Devcontainer

This folder contains a Laravel-ready Development Container configuration.

## Included
- PHP 8.2 base image
- Node.js 20 (via devcontainer feature)
- Composer, Git, GitHub CLI
- sqlite dependencies for local testing

## First start
On container creation, `.devcontainer/post-create.sh` runs automatically and performs:
- `composer install`
- `npm install`
- `.env` creation from `.env.example` (if missing)
- `php artisan key:generate`
- `database/database.sqlite` creation

## Daily commands
```bash
composer run dev
composer run test
```
