# Laravel Products CRUD
Products and categories with create, read, update, delete, validation, and an Eloquent one-to-many relationship.

## Run it

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Then open http://127.0.0.1:8000/products