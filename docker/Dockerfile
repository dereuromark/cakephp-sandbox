FROM dunglas/frankenphp:latest

# Install system dependencies for PHP extensions.
# wkhtmltox: the CakePdf WkHtmlToPdf engine binary. Upstream is archived and gone
# from Debian repos, so pull the pre-built bookworm .deb (works on bookworm and
# trixie). The patched-qt build is headless, so no X server is needed.
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    graphviz \
    libheif-examples \
    && curl -fsSL -o /tmp/wkhtmltox.deb \
        "https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6.1-3/wkhtmltox_0.12.6.1-3.bookworm_amd64.deb" \
    && apt-get install -y --no-install-recommends /tmp/wkhtmltox.deb \
    && rm -f /tmp/wkhtmltox.deb \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN install-php-extensions \
    bcmath \
    exif \
    imagick \
    intl \
    pcntl \
    pdo_mysql \
    zip \
    opcache \
    gd \
    redis

# PHP configuration
RUN echo "upload_max_filesize = 32M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 32M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "display_errors = Off" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "log_errors = On" >> /usr/local/etc/php/conf.d/errors.ini
