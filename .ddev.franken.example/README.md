# DDEV FrankenPHP Configuration

This folder contains example configuration files for running the sandbox with FrankenPHP and Mercure.

## Setup

1. Copy this folder to `.ddev`:
   ```bash
   cp -r .ddev.franken.example/* .ddev/
   ```

2. Create your Mercure secrets file (not committed):
   ```bash
   cp .ddev/docker-compose.mercure.yaml.example .ddev/docker-compose.mercure.yaml
   # Edit and set your own JWT keys
   ```

3. Create your CakePHP Mercure config:
   ```bash
   cp config/app_mercure.default.php config/app_mercure.php
   # Edit and set matching JWT secret
   ```

4. Restart DDEV:
   ```bash
   ddev restart
   ```

## What's Included

- **config.frankenphp.yaml** - DDEV config for FrankenPHP with worker mode and queue worker
- **docker-compose.mercure.yaml.example** - Environment variables for Mercure JWT keys
- **frankenphp/Caddyfile** - Caddy configuration with worker mode and Mercure hub
- **web-build/** - Dockerfile fragments to install FrankenPHP in DDEV

## Features

- **Worker Mode**: PHP stays in memory for faster responses (see bolt icon in footer)
- **Mercure Hub**: Real-time updates via Server-Sent Events
- **Queue Worker**: Background job processing via CakePHP Queue plugin
