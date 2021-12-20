# Little Miracles Portal

## Installation
```bash
cp readme/env.env .env
composer install
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run dev
npm run prod
```

## Commands
- Generate API Docs `php artisan l5-swagger:generate`
- Fresh Install `php artisan migrate:fresh && php artisan db:seed && php artisan passport:install`
