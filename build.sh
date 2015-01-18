#!/bin/bash

echo "### INSTALL ###";

php composer.phar selfupdate

git pull

php composer.phar update --prefer-dist --no-dev --optimize-autoloader

echo "### CLEANUP ###";
# cleanup
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

chown -R www-data:www-data *

echo ### DONE ###;
exit
