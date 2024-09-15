#!/bin/bash
# Warning: This is NOT a productive script, but for local dev envs only!

#set -o pipefail

COMPOSER_ALLOW_SUPERUSER=1 composer install

[ ! -f config/app_local.php ] && cp config/app_local.default.php config/app_local.php && echo "ERROR: DB credentials missing, enter them now and run again!" && exit 1

mkdir -p ./tmp
mkdir -p ./logs
mkdir -p ./webroot/js/cjs/
mkdir -p ./webroot/css/ccss/
mkdir -p ./webroot/assets/

chmod +x bin/cake

echo "### START ###";
bin/cake maintenance_mode activate

bin/cake queue worker end all

echo "### DB MIGRATION ###";
COMPOSER_ALLOW_SUPERUSER=1 composer migrate

echo "### ASSETS ###";
#npm install -g bower
#npm install -g ttembed-js
bower install
COMPOSER_ALLOW_SUPERUSER=1 composer assets

ttembed-js ./webroot/assets/font-awesome/fonts/fontawesome-webfont.ttf

mkdir -p ./webroot/css/fonts
cp -R ./webroot/assets/bootstrap-icons/font/fonts/* ./webroot/css/fonts/
cp -R ./webroot/assets/font-awesome/fonts/* ./webroot/css/fonts/

echo "### CLEANUP ###";
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

bin/cake cache clear_all
bin/cake schema_cache build

echo "### IDE HELPER ###";
COMPOSER_ALLOW_SUPERUSER=1 composer setup

echo "### FINISH ###"
bin/cake maintenance_mode deactivate

echo "### DONE ###";

exit 0
