init:
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli php artisan migrate
	docker-compose run --rm php-cli php artisan db:seed

build:
	docker-compose build

down:
	docker-compose down

run:
	docker-compose up -d

test:
	docker-compose run --rm php-cli php artisan test --testsuite=Feature --stop-on-failure
