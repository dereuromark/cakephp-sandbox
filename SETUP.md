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

#### Use CakeBox as VM
Hot tip: Using [CakeBox](https://github.com/alt3/cakebox) is the fast way to get it working on any OS.
Just follow the docs there, log in and create a project:
```
cakebox application add sandbox.local
```
Then remove that `sandbox.local` folder in /Apps/ and instead clone the sandbox into it.

In this case the hosts entry would more look like:
```
10.33.10.10 cakebox sandbox.local
```
The `add` command from above should automatically do that. If not, adjust your hosts file manually.

Then inside the vagrant machine navigate to `/Apps/sandbox.local/` and execute
```
./setup
```

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
