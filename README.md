                        How to run project

1. git clone https://github.com/JanisKaucis/MaponTask.git
2. composer install
3. Duplicate the .env.example file and rename it to .env
4. Open the .env file and set your database connection details
5. php artisan key:generate
6. php artisan migrate
7. npm install
8. npm run dev
9. php artisan serve

And thats it, now you can run commands to get data about Euro foreign exchange
reference rates.

1. php artisan app:get-actual-currency-data-from-bank-a-p-i
   This command gets actual data about all currency exchange rates for EUR to other currencies
   for current day.
2. php artisan app:get-actual-currency-data-for-last-7-days-from-bank-a-p-i
   This command gets actual data about all currency exchange rates for EUR to other currencies
   for last 7 days.

                             How to set up for docker
   I could be wrong about this one, but I will try:
1. php artisan sail:install
2. choose your database server from menu
3. ./vendor/bin/sail up or ./vendor/bin/sail up -d for docker
4. php artisan migrate
5. npm run dev
             And that is it


