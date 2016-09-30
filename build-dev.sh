#!/bin/bash
# Warning: This is NOT a productive script, but for local dev envs only!

echo "### INSTALL/UPDATE ###";
[ ! -f composer.phar ] && curl -sS https://getcomposer.org/installer | php
php composer.phar selfupdate

git pull

php composer.phar install --prefer-dist --optimize-autoloader --no-interaction

chmod +x bin/cake

mkdir -p ./tmp
mkdir -p ./logs
mkdir -p ./webroot/js/cjs/
mkdir -p ./webroot/css/ccss/

echo "### DB MIGRATION ###";
bin/cake Migrations migrate

echo "### ASSETS ###";
bower install --allow-root
bin/cake AssetCompress.AssetCompress build

#sudo npm install -g ttembed-js
ttembed-js ./webroot/css/fonts/fontawesome-webfont.ttf

echo "### CLEANUP ###";
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

echo "### DONE ###";
