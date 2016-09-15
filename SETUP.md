# CakePHP Sandbox APP - How to setup

If you want to contribute, these are the basic steps to get the repo to run locally.

### Installation

First, clone the repo into a root folder:

	git clone https://github.com/dereuromark/cakephp-sandbox.git

Then:

* Set up your `app_local.php` file in `/config`.
This will not be version-controlled. I use it for email setup, API keys and core salt value etc.
* Make sure you are in debug mode (`true`).

Manually you can run the following commands one by one:

```
composer install
bin/cake Migrations migrate
```

But it is easier to run the quick command here doing it all at once:
```
./build-dev.sh
```
Everything should be up and running.

Consider using a vhost setup to map the base path to `http://sandbox.local/`.
This will ensure that all linked assets will be found. Should also work without, though.

### Contributing

* Use the Sandbox plugin to create more sandbox functionality
* Submit your changes via PR (pull request).

Please check the quality of your changes via
```
./sniff
```
You can auto-fix most issues with
```
./sniff -f
```
