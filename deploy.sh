#!/usr/bin/env bash
set -euo pipefail

git pull
composer install -n
./vendor/bin/sail artisan migrate --seed --force
./vendor/bin/sail artisan optimize:clear
# Dependencies may have been created by root during earlier deployments.
docker compose exec -T --user root laravel.test sh -c '
    if [ -d /var/www/html/node_modules ]; then
        chown -R "$(id -u sail):$(id -g sail)" /var/www/html/node_modules
    fi
'
./vendor/bin/sail npm ci
./vendor/bin/sail npm run build
