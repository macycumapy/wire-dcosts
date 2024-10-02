git pull
composer install -n
./vendor/bin/sail artisan migrate --seed --force
./vendor/bin/sail artisan optimize:clear
./vendor/bin/sail npm install
./vendor/bin/sail npm run build


