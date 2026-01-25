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

* Set up your `app_local.php` file in `config/`.
This will not be version-controlled. I use it for email setup, API keys and core salt value etc.
* Make sure you are in debug mode (`true`).

#### Use DDEV as VM
Using [ddev](https://docs.ddev.com/en/stable/) is the recommended way for local development.

Browse into your app directory in your console and create a `.ddev/` folder.

**Option A: Standard DDEV (Apache/nginx + PHP-FPM)**

Copy the basic config:
```bash
cp -r .ddev.example/* .ddev/
```

**Option B: FrankenPHP with Mercure (recommended)**

For better performance (worker mode) and real-time features (Mercure):
```bash
cp -r .ddev.example/* .ddev/
cp -r .ddev.franken.example/* .ddev/
cp .ddev/docker-compose.mercure.yaml.example .ddev/docker-compose.mercure.yaml
# Edit docker-compose.mercure.yaml and set your own JWT keys
cp config/app_mercure.default.php config/app_mercure.php
# Edit app_mercure.php with matching JWT secret
```

See `.ddev.franken.example/README.md` for more details on FrankenPHP features.

---

Once configured, start the container(s):
```bash
ddev start
```

Once up and running, you can log into the container:
```
ddev ssh
```

Run the quick command here doing it all at once:
```
./setup
```
Everything should be up and running, including assets and seed (demo) data.

You can also look into that file and just those commands manually, one by one, of course.
```
composer install
composer migrate
bin/cake seeds run
...
```


#### Using Devilbox or custom (deprecated)
If you are not using ddev, consider using a vhost setup to map the base path to `http://sandbox.local/`.
This will ensure that all linked assets will be found. Should also work without, though.

Using [Devilbox](https://github.com/cytopia/devilbox) should also  be working on any OS.

Just follow the [docs](https://github.com/cytopia/devilbox?tab=readme-ov-file#-quickstart) there.
Make sure:
- PHP 8.4+

You need will also have to adjust the `.env` file a bit:

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
./setup.sh
```

Tip: Customize your `bash/bashrc.sh` file.
At the end, add your aliases as well as the cd command:
```
alias c='composer'
...

cd sandbox
````
This way you don't need to navigate inside anymore, it will auto-jump you to the repo root.

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
