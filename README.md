## Stargting

It's a default laravel application, so you only need to run
- composer install  
- php artisan migrate:refresh --seed  
command to install all needed libraries and fill database
- php artisan serve  
to run it.  

## Tests

To fill test database, run command
- php artisan migrate --database=testing
To run test, use
- php artisan test
