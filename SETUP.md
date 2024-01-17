# CakePHP Sandbox APP - How to setup

These are the basic steps to get the repo to run locally.

### Dependencies

* CakePHP core and plugins via composer (v2)
* NPM or bower for assets

### Installation

First, clone the repo:
```
git clone https://github.com/dereuromark/cakephp-sandbox.git
```

Then:

* Set up your `app_local.php` file in `/config`.
This will not be version-controlled. I use it for email setup, API keys and core salt value etc.
* Make sure you are in debug mode (`true`).

Manually you can run the following commands one by one:

```
composer install
composer migrate
```

But it is easier to run the quick command here doing it all at once:
```
./setup
```
Everything should be up and running.

Consider using a vhost setup to map the base path to `http://sandbox.local/`.
This will ensure that all linked assets will be found. Should also work without, though.

Note: You need to install the assets yourself somehow. You can also look into `build.sh` and how the deployment script handles it.
In the end you just have to get them installed somehow for the AssetCompress plugin to pick them up.

#### Use Devilbox as VM
Hot tip: Using [Devilbox](https://github.com/cytopia/devilbox) is the fast way to get it working on any OS.

Just follow the [docs](https://github.com/cytopia/devilbox?tab=readme-ov-file#-quickstart) there.
You need to adjust the `.env` file a bit, though.

Set HTTPD_DOCROOT_DIR for easier work with CakePHP:
```
HTTPD_DOCROOT_DIR=webroot
```

Set up `/etc/hosts` entries for your domains, e.g.
```
127.0.0.1 sandbox.local
```

Inside the devilbox navigate into `data/www/` dir and clone the sandbox repo
```
git clone git@github.com:dereuromark/cakephp-sandbox.git sandbox
```
You can also use https if you don't have ssh setup yet.

Now you should be able to start up the containers:
```
docker-composer up -d
```
And log in using
```
./shell.sh
```

Then inside container navigate to `sandbox/` and execute
```
./install.sh
```

Tip: Customize your `bash/bashrc.sh` file.
At the end, add your aliases as well as the cd command:
```
alias c='composer'
...

cd sandbox
````
This way you don't need to navigate inside anymore, it will auto-jump you to the repo root.

#### Use Traefix and docker containers as VM
See https://github.com/dereuromark/sandbox-docker?tab=readme-ov-file#installation

Note: Requires HTTPS setup, but otherwise is quicker.

### Creating Admin User
In case you want to check out the admin area (`/admin`), you want to create an admin user.
You can do that via command line:
```
bin/cake user create yourname yourpassword
```

For the role select `1` (=admin) manually, and confirm the save operation. You should now be able to log in.

Note: Do you not use the usernames `admin`, `mod`, `user` as those come shipped along with the migrations seeding data for the sandbox examples.
If you want to use those to log in check the Auth sandbox part.

### Contributing

* Use the Sandbox plugin to create more sandbox functionality
* Submit your changes via PR (pull request).

The tests should pass: `composer test`

PHPStan is
```
composer stan
```

Please make sure the coding style is fine for your changes via
```
composer cs-check
```
You can auto-fix most issues with
```
composer cs-fix
```
