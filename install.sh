#!/bin/bash
# Warning: Only run this once for first install, afterwards run ./setup.sh

set -o pipefail

php composer.phar install

[ ! -f config/app_local.php ] && cp config/app_local.default.php config/app_local.php && echo "ERROR: DB credentials missing, enter them now and run again!" && exit 1

mkdir -p ./tmp
mkdir -p ./logs
mkdir -p ./webroot/js/cjs/
mkdir -p ./webroot/css/ccss/

chmod +x bin/cake

# Database for testing
mysql --host=mariadb --password=geheim -u root -e "create database test";

php composer.phar migrate

bin/cake seeds run

# Assets
mkdir -p tmp
mkdir -p logs
mkdir -p webroot/js/cjs/
mkdir -p webroot/css/ccss/

bower install --allow-root
php composer.phar assets
