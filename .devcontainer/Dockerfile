FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

# Install system dependencies commonly used by Laravel plus DB/queue tooling.
RUN apt-get update \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        gnupg \
        git \
        mariadb-client \
        redis-tools \
        sqlite3 \
        libsqlite3-dev \
        libmariadb-dev-compat \
        libmariadb-dev \
        libicu-dev \
        libzip-dev \
        unzip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-install -j"$(nproc)" intl pdo_mysql pdo_sqlite zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /workspaces/bestatter
