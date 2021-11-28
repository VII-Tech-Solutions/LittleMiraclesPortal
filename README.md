# Little Miracles Portal

## Installation
```bash
cp readme/env.env .env
composer install
php artisan migrate
php artisan db:seed
php artisan storage:link
```

## Commands
- Generate API Docs `php artisan l5-swagger:generate`
