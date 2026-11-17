# explorer.navcoin.org

This is the repository for the frontend of explorer.navcoin.org.

## Requirements

- PHP 8.3 (>= 8.2.35; older versions are affected by CVE-2026-109618 / CVE-2026-109619)
- Composer (latest)
- Symfony cli (lts, currently 5.*)

## Setup

Install PHP and JS dependencies:
```sh
composer install
yarn install
```

Build frontend assets:
```sh
yarn encore dev

# use this command to enable watch mode when developing
yarn encore dev --watch
```

Start the server:
```sh
symfony server:start --port 8888
```

Go to https://localhost:8888 to view the site.
