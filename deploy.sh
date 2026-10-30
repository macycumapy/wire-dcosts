#!/usr/bin/env bash
set -euo pipefail

test -s public/build/manifest.json || { echo "Frontend build is missing" >&2; exit 1; }

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
./vendor/bin/sail artisan migrate --seed --force
./vendor/bin/sail artisan optimize:clear
