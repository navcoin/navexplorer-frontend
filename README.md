# NavExplorer.com

This is the repository for the frontend of navexplorer.com.

## Requirements

- PHP 7.4
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
