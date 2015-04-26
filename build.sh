#!/bin/bash
# Warning: This is NOT a productive script, but for local dev envs only!

echo "### INSTALL/UPDATE ###";
php composer.phar selfupdate

git pull

php composer.phar update --prefer-dist --no-dev --optimize-autoloader --no-interaction

chmod +x bin/cake

mkdir -p ./webroot/js/cjs/
mkdir -p ./webroot/css/ccss/

echo "### ASSETS ###";
bin/cake AssetCompress.AssetCompress build

echo "### DB MIGRATION ###";
bin/cake Migrations migrate

echo "### CLEANUP ###";
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

chown -R www-data:www-data *
chmod -R 0770 ./tmp
chmod -R 0770 ./logs

echo "### DONE ###";
exit;
