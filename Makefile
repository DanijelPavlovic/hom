run:
	 php -S localhost:8000 -t public

start-db:
	docker compose up -d

migrations:
	php artisan migrate

seed:
	php artisan db:seed
