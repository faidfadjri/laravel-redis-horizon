# Laravel Redis Queue with Horizon

### Installation Guide

Clone Repository
```bash
git clone https://github.com/faidfadjri/laravel-redis-horizon.git
```

Rename **.env.example** to **.env** and set your database configuration
```yaml
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USERNAME
DB_PASSWORD=YOUR_DATABASE_PASSWORD
```

Setup project using one command (using makefile script) it will run several command :
- composer install
- php artisan migrate
- php artisan migrate:refresh
- php artisan db:seed
- php artisan passport:install

```bash
make setup
```

> use makefile to simplify the Artisan command you can check it out on **makefile**
