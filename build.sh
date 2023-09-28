#!/bin/bash
# Warning: This is NOT a productive script, but for local dev envs only!

echo "### INSTALL/UPDATE ###";
[ ! -f composer.phar ] && curl -sS https://getcomposer.org/installer | php
php composer.phar selfupdate

git pull

php composer.phar install --prefer-dist --no-dev --optimize-autoloader --no-interaction

chmod +x bin/cake

bin/cake maintenance_mode activate

bin/cake queue worker end all

mkdir -p tmp
mkdir -p logs
mkdir -p webroot/js/cjs/
mkdir -p webroot/css/ccss/

echo "### DB MIGRATION ###";
COMPOSER_ALLOW_SUPERUSER=1 composer migrate --no-interaction

echo "### ASSETS ###";
bower install --allow-root
COMPOSER_ALLOW_SUPERUSER=1 composer assets

bin/cake asset_compress build

echo "### CLEANUP ###";
rm -rf tmp/cache/models/*
rm -rf tmp/cache/persistent/*
rm -rf tmp/cache/views/*

bin/cake cache clear_all
bin/cake schema_cache build

bin/cake maintenance_mode deactivate

chown -R www-data:www-data *
chmod -R 0770 tmp
chmod -R 0770 logs
chmod -R 0770 webroot/js/cjs/
chmod -R 0770 webroot/css/ccss/

echo "### DONE ###";
