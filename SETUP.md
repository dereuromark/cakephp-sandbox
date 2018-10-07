# CakePHP Sandbox APP - How to setup

If you want to contribute, these are the basic steps to get the repo to run locally.

This branch is for **CakePHP 2.x**. It is **deprecated**, please use the 3.x one now.

### Installation

First, clone the repo into a root folder:

	git clone https://github.com/dereuromark/cakephp-sandbox.git

Then make sure, core + all plugins are also available.
This should be done using composer from your application dir:

	composer install

and from there on

	composer update

Consider using a vhost setup to map the base path to `http://sandbox.local/`.
This will ensure that all linked assets will be found. Should also work without, though.

Then:

* Set up your database.php file in /Config.
* Optionally create a configs_private.php file with your custom and local settings.
Those will not be version-controlled. I use it for email setup, API keys and core salt value etc.
* Make sure you are in debug mode (2).

Everything should be up and running.

### Contributing

* Use the Sandbox plugin to create more sandbox functionality
* Submit your changes via PR (pull request).

Please check the quality of your changes via [CodeSniffer](https://github.com/dereuromark/cakephp-codesniffer),
ideally with my MyCakePHP sniff package. You can use my convenience shell command that
also includes auto-correction for found issues:

	cake CodeSniffer.CodeSniffer run -s MyCakePHP -p Sandbox -v

To correct fixable errors:

	cake CodeSniffer.CodeSniffer run -s MyCakePHP -p Sandbox -v -f
