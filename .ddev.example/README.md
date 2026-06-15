# DDEV configuration (FrankenPHP + Mercure)

The single, recommended local-dev setup for the sandbox: DDEV running FrankenPHP
(worker mode) with a Mercure hub and a CakePHP queue worker.

## Setup

1. Copy this folder to `.ddev/` (the trailing `/.` also copies dotfiles like `.env.web`):
   ```bash
   cp -r .ddev.example/. .ddev/
   ```

2. Create your Mercure secrets file (not committed):
   ```bash
   cp .ddev/docker-compose.mercure.yaml.example .ddev/docker-compose.mercure.yaml
   # Edit and set your own JWT keys
   ```

3. Create your CakePHP Mercure config:
   ```bash
   cp config/app_mercure.default.php config/app_mercure.php
   # Edit and set the matching JWT secret
   ```

4. Start DDEV:
   ```bash
   ddev start
   ```

## What's included

- **config.yaml** - base DDEV project config
- **config.frankenphp.yaml** - FrankenPHP webserver (worker mode) + queue worker daemon
- **frankenphp/Caddyfile** - Caddy config with worker mode and the Mercure hub
- **web-build/** - Dockerfile fragments that install FrankenPHP into the web image
- **docker-compose.mercure.yaml.example** - template for the Mercure JWT keys
- **php/session.ini** - PHP session overrides
- **.env.web** - web-image build args (FrankenPHP Debian release + PHP extensions)

## Features

- **Worker mode** - PHP stays in memory for faster responses (bolt icon in the footer)
- **Mercure hub** - real-time updates via Server-Sent Events
- **Queue worker** - background job processing via the CakePHP Queue plugin

## Debian release pinning

`web-build/prepend.Dockerfile.frankenphp` copies FrankenPHP's `/usr` over the
ddev-webserver base. The FrankenPHP source image **must** match the base Debian
release, or the copy downgrades glibc and the build fails with
`apt-get: ... GLIBC_2.x not found`. DDEV v1.25.x uses **trixie**, so `.env.web`
sets `FRANKENPHP_DEBIAN_CODENAME="trixie"`. If a future DDEV bumps the base
release, update that one value.
