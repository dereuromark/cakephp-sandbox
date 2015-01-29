#!/bin/bash

echo "### INSTALL/UPDATE ###";
php composer.phar selfupdate

git pull

php composer.phar update --prefer-dist --no-dev --optimize-autoloader

echo "### DB MIGRATION ###";
bin/cake Migrations.migrate

echo "### CLEANUP ###";
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

chown -R www-data:www-data *

echo ### DONE ###;
exit
