init:
	docker-compose up -d --build
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli php artisan key:generate
	docker-compose run --rm php-cli php artisan storage:link
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
