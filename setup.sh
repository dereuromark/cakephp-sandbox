#!/bin/bash
# Warning: This is NOT a productive script, but for local dev envs only!

set -o pipefail

php composer.phar install

[ ! -f config/app_local.php ] && cp config/app_local.default.php config/app_local.php && echo "ERROR: DB credentials missing, enter them now and run again!" && exit 1

mkdir -p ./tmp
mkdir -p ./logs
mkdir -p ./webroot/js/cjs/
mkdir -p ./webroot/css/ccss/

chmod +x bin/cake

php composer.phar migrate

echo "### ASSETS ###";
#npm install -g bower
#npm install -g ttembed-js
bower install

ttembed-js ./webroot/assets/font-awesome/fonts/fontawesome-webfont.ttf

mkdir -p ./webroot/css/fonts
cp -R ./webroot/assets/bootstrap/dist/fonts/* ./webroot/css/fonts/
cp -R ./webroot/assets/font-awesome/fonts/* ./webroot/css/fonts/

echo "### CLEANUP ###";
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

echo "### IDE HELPER ###";
php composer.phar setup

echo "### DONE ###";

exit 0
