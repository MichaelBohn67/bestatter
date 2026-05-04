#!/usr/bin/env bash
set -euo pipefail

cd /workspaces/bestatter

if [ "${SKIP_DEVCONTAINER_MIGRATIONS:-0}" = "1" ]; then
  echo "Skipping migrations (SKIP_DEVCONTAINER_MIGRATIONS=1)."
  exit 0
fi

if [ ! -f artisan ] || [ ! -f .env ]; then
  echo "Skipping migrations (artisan or .env missing)."
  exit 0
fi

# Retry migrations a few times in case db startup is still in progress.
for i in $(seq 1 15); do
  if php artisan migrate --force; then
    echo "Migrations completed."
    exit 0
  fi

  echo "Migration attempt ${i}/15 failed, retrying in 3s..."
  sleep 3
done

echo "Migrations did not succeed after retries."
exit 1
