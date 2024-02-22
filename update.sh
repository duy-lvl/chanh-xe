./vendor/bin/sail npm install
./vendor/bin/sail composer install

if echo $* | grep -e "--fresh" -q
then
  ./vendor/bin/sail artisan migrate:fresh --seed
else
  ./vendor/bin/sail artisan migrate
fi


