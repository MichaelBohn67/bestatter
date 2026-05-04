#!/usr/bin/env bash
set -euo pipefail

cd /workspaces/bestatter

if [ -f composer.json ]; then
  composer install --no-interaction --prefer-dist
fi

if [ -f package.json ]; then
  npm install
fi

if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

php artisan key:generate --force || true

mkdir -p database
touch database/database.sqlite

echo "Devcontainer setup complete."
