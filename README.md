## Stargting

It's a default laravel application, so you only need to run
- composer install
- php artisan migrate:refresh --seed
- cp .env.example .env
  command to prepare project.  
  (You'll also need to update .env file for your settings)
- php artisan serve  
  to run it.

## Tests

To fill test database, run command
- php artisan migrate --database=testing
  To run test, use
- php artisan test
