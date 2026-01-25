# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A CakePHP 5.x sandbox application showcasing CakePHP features, plugins, and tools. This is a live demo application (https://sandbox.dereuromark.de) with custom exception handling, DB logging, and extensive plugin examples.

## Architecture

### Plugin-Based Structure

The codebase uses a modular plugin architecture with three main plugins in `/plugins/`:
- **Sandbox**: Misc. examples and plugin showcases (most example code)
- **AuthSandbox**: Authentication examples
- **StateMachineSandbox**: State machine examples with Queue integration

The main application (`/src/`) contains core controllers, user management, and admin functionality.

### Key Components

- **AppController** (`src/Controller/AppController.php`): Uses TinyAuth for authentication/authorization, Flash component, and Tools.Common component. Extends `Tools\Controller\Controller` with `RedirectOutOfBoundsTrait`.
- **Authentication**: TinyAuth with MultiColumn authenticator supporting username/email login.
- **Routing**: Uses DashedRoute by default. Admin routes use `/admin` prefix. Plugins configured in `config/plugins.php`.
- **Middleware Stack**: Custom ErrorHandlerMiddleware, MaintenanceMiddleware, CacheMiddleware, RedirectMiddleware.

### Database Conventions

Standard CakePHP conventions enforced:
- Tables: plural snake_case (e.g., `sandbox_users`, `sandbox_posts`)
- Foreign keys: `{singular_table}_id`
- Auto-managed timestamps: `created` and `modified` fields

## Development Commands

### Setup & Installation

Initial setup:
```bash
./install.sh              # First-time install (runs migrations, seeds, assets)
./setup.sh                # Subsequent setup (after pull, for dev env)
```

Manual steps:
```bash
composer install
composer migrate          # Runs migrations for app + all plugins
bin/cake seeds run        # Seed demo data
composer assets           # Install npm assets via package.json
```

### Database

```bash
composer migrate                      # Run all migrations
bin/cake migrations migrate           # Run app migrations
bin/cake migrations migrate -p Queue  # Run plugin migrations
bin/cake seeds run                    # Seed all demo data
bin/cake seeds run Cities             # Seed specific seeder
bin/cake seeds status                 # Show seed status
```

### Testing

```bash
composer test                         # Run all tests via PHPUnit
vendor/bin/phpunit                    # Run all tests
vendor/bin/phpunit --filter testMethodName  # Run specific test method
vendor/bin/phpunit --testsuite app    # Run app tests
vendor/bin/phpunit --testsuite sandbox # Run Sandbox plugin tests
composer test-coverage                # Generate coverage reports
```

Test suites: `app`, `sandbox`, `auth-sandbox`, `state-machine-sandbox`

### Code Quality

```bash
composer cs-check  # Check coding standards (PSR2R via phpcs.xml)
composer cs-fix    # Auto-fix coding standard violations
composer stan      # Run PHPStan level 8 analysis (phpstan.neon)
composer stan-tests # Run PHPStan on test files
```

### IDE Helper & Code Generation

```bash
composer setup     # Generate IDE helper files (code_completion + phpstorm)
composer annotate  # Add annotations to app + all plugins
composer dto       # Generate DTOs for Sandbox plugin
bin/cake bake model MyModel --theme Setup  # Use Setup theme for baking
```

### Assets & Cache

```bash
composer assets             # Install/copy frontend assets from npm
bin/cake asset_compress build # Build compressed assets
bin/cake cache clear_all    # Clear all caches
bin/cake schema_cache build # Rebuild schema cache
```

### Queue & Maintenance

```bash
bin/cake queue worker end all     # Stop all queue workers
bin/cake maintenance_mode activate   # Enable maintenance mode
bin/cake maintenance_mode deactivate # Disable maintenance mode
```

### User Management

```bash
bin/cake user create username password  # Create user (select role 1 for admin)
```

## Architecture Notes

### Authentication & Authorization

- TinyAuth handles both authentication (MultiColumn) and authorization (Tiny adapter)
- Login fields: `login` (username) and `password`, with fallback to email
- User model: `Users` table
- Admin access requires role_id = 1
- Avoid usernames `admin`, `mod`, `user` (reserved for seed data)

### Testing Patterns

- Uses `Shim\TestSuite\IntegrationTestCase` for controller tests
- Fixture factories preferred over traditional fixtures (dereuromark/cakephp-fixture-factories)
- Test URLs must be arrays: `$this->get(['controller' => 'Overview', 'action' => 'index'])`
- Each test method should have only ONE `get()`/`post()` call
- Flash message tests: add `$this->enableRetainFlashMessages()` in test setup

### Frontend Assets

- Asset management via `markstory/asset_compress` plugin
- Frontend dependencies in `package.json` (Bootstrap icons, Font Awesome, Feather icons, etc.)
- Assets copied to `webroot/assets/` and fonts to `webroot/css/fonts/`
- Compiled JS/CSS output: `webroot/js/cjs/` and `webroot/css/ccss/`

### Configuration Files

- `config/app_local.php`: Local config (not version-controlled) - DB, email, API keys, salt
- `config/plugins.php`: Plugin loading configuration
- `config/routes.php`: Route definitions
- `phpcs.xml`: Coding standards (PSR2R ruleset)
- `phpstan.neon`: Static analysis config (level 8)

## Git Commit Guidelines

- NEVER commit unrelated files, especially personal notes or planning `.md` files in the root directory
- Before committing, always review `git status` carefully to ensure only relevant files are staged
- Files like `_*.md` should remain local and untracked

## CakePHP 5 Patterns

See global CLAUDE.md for general CakePHP patterns. Project-specific notes:
- Query methods: Use `groupBy()` and `orderBy()` (not deprecated `group()`/`order()`)
- Table loading: Prefer `fetchTable()` over `loadModel()`
- Result sets: Always call `->toArray()` unless paginated
- Baking: Use `--theme Setup` for consistency
- Annotations: Run `composer annotate` after model changes
- DTOs: Generated via `composer dto`, stored in `plugins/Sandbox/src/Dto/`
