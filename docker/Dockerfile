FROM dunglas/frankenphp:latest

# Install system dependencies for PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN install-php-extensions \
    intl \
    pdo_mysql \
    zip \
    opcache \
    gd
