FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

# Install system dependencies commonly used by Laravel and sqlite-based tests.
RUN apt-get update \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y --no-install-recommends \
        sqlite3 \
        libsqlite3-dev \
        libicu-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" intl pdo_sqlite zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /workspaces/bestatter
