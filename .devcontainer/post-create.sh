#!/usr/bin/env bash
set -euo pipefail

cd /workspaces/bestatter

if [ ! -f .env.devcontainer ] && [ -f .env.example ]; then
  cp .env.example .env.devcontainer
  sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env.devcontainer
  sed -i 's/^# DB_HOST=.*/DB_HOST=db/' .env.devcontainer
  sed -i 's/^# DB_PORT=.*/DB_PORT=3306/' .env.devcontainer
  sed -i 's/^# DB_DATABASE=.*/DB_DATABASE=bestatter/' .env.devcontainer
  sed -i 's/^# DB_USERNAME=.*/DB_USERNAME=bestatter/' .env.devcontainer
  sed -i 's/^# DB_PASSWORD=.*/DB_PASSWORD=bestatter/' .env.devcontainer
  sed -i 's/^REDIS_HOST=.*/REDIS_HOST=redis/' .env.devcontainer
fi

if [ -f composer.json ]; then
  composer install --no-interaction --prefer-dist
fi

if [ -f package.json ]; then
  npm install
fi

if [ ! -f .env ] && [ -f .env.devcontainer ]; then
  cp .env.devcontainer .env
fi

php artisan key:generate --force || true

mkdir -p database
touch database/database.sqlite

echo "Devcontainer setup complete."
