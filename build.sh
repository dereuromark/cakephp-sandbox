#!/bin/bash

echo "### INSTALL ###";

FILE="composer.phar"
if [ -f $FILE ];
then
	echo ""
else
	curl -sS https://getcomposer.org/installer | php
fi

php composer.phar selfupdate

git pull

php composer.phar install --prefer-dist --no-dev --optimize-autoloader --no-interaction

echo ### FOLDERS ###;
mkdir -p ./tmp/cache/persistent
mkdir -p ./tmp/cache/models
mkdir -p ./tmp/cache/data
mkdir -p ./tmp/cache/short
mkdir -p ./webroot/js/cjs
mkdir -p ./webroot/css/ccss
mkdir -p ./webroot/assets

chmod -R 0770 ./tmp
chmod -R 0770 ./files
chmod -R 0770 ./webroot/js/cjs
chmod -R 0770 ./webroot/css/ccss
chmod -R 0770 ./webroot/img
chmod -R 0770 ./webroot/assets

echo "### ASSETS ###";
bower install --allow-root
npm install -g ttembed-js
ttembed-js ./webroot/assets/font-awesome/fonts/fontawesome-webfont.ttf
Console/cake AssetCompress.AssetCompress build

mkdir -p ./webroot/css/fonts
cp -R ./webroot/assets/bootstrap/fonts/* ./webroot/css/fonts
cp -R ./webroot/assets/font-awesome/fonts/* ./webroot/css/fonts

echo "### CLEANUP ###";

rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*
rm -rf ./tmp/cache/views/*
rm -rf ./tmp/cache/data/*
rm -rf ./tmp/cache/short/*

chown -R www-data:www-data *
chmod -R 0770 ./tmp

echo ### DONE ###;
