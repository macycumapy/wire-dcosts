git pull
composer install
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan optimize:clear
./vendor/bin/sail npm install
./vendor/bin/sail npm run build


