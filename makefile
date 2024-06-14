db-seed:
	php artisan db:seed

db-refresh:
	php artisan migrate:refresh

db-rollback:
	php artisan migrate:rollback

db-migrate:
	php artisan migrate

refresh:
	@make db-refresh
	@make db-seed
