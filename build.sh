#!/bin/bash
# FrankenPHP Docker deployment script

set -e

DOCKER_DIR="/var/www/dereuromark/franken/docker"
APP_DIR="/var/www/dereuromark/franken"

cd "$APP_DIR"

git pull

echo "### Maintenance mode ON ###"
docker exec docker-frankenphp-1 php /app/bin/cake.php maintenance_mode activate

echo "### Stop queue worker ###"
# Signal worker to stop accepting new jobs (finishes current job then exits)
docker exec docker-queue-1 php /app/bin/cake.php queue worker end all 2>/dev/null || true

# Wait for worker to exit gracefully (up to 120 seconds)
echo "Waiting for queue worker to finish current job..."
docker compose -f "$DOCKER_DIR/docker-compose.yml" stop -t 120 queue

echo "### Composer install ###"
composer install --prefer-dist --no-dev -a --no-interaction

echo "### DB MIGRATION ###"
composer migrate --no-interaction

echo "### ASSETS ###"
bower install --allow-root
composer assets
docker exec docker-frankenphp-1 php /app/bin/cake.php asset_compress build

echo "### CLEANUP ###"
rm -rf tmp/cache/models/*
rm -rf tmp/cache/persistent/*
rm -rf tmp/cache/views/*

docker exec docker-frankenphp-1 php /app/bin/cake.php cache clear_all
docker exec docker-frankenphp-1 php /app/bin/cake.php schema_cache build

echo "### Maintenance mode OFF ###"
docker exec docker-frankenphp-1 php /app/bin/cake.php maintenance_mode deactivate

echo "### Restart services ###"
docker compose -f "$DOCKER_DIR/docker-compose.yml" restart frankenphp
docker compose -f "$DOCKER_DIR/docker-compose.yml" start queue

chown -R www-data:www-data "$APP_DIR"
chmod -R 0770 tmp logs webroot/js/cjs/ webroot/css/ccss/

echo "### DONE ###"
