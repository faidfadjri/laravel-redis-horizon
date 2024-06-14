# Laravel Redis Queue with Horizon


#### Services 🐕‍🦺
- [MySQL](https://www.mysql.com/)
- [Redis](https://redis.io/)

#### Composer Dependencies 🍹
- [Laravel Passport](https://laravel.com/docs/10.x/passport)
- [Predis](https://packagist.org/packages/predis/predis)


#### Installation Guide 🏒

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


Open new terminal and run the Redis Server
```bash
redis-server
```
Open new terminal for running the queue job
```bash
php artisan queue:work redis --queue=default
```
