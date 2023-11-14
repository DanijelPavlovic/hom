start:
	 php -S localhost:8000 -t public

db-start:
	docker compose up -d

db-stop:
	docker compose down

migrations:
	php artisan migrate

seed:
	php artisan db:seed
