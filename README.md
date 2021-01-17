#Test basic web application 

###Install

- `cp .env.example .env`

Configuration with docker

```yaml
APP_URL=http://localhost:8080

...

DB_CONNECTION=mysql
DB_HOST=test-mysql
DB_PORT=3306
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=password
```

####If you have docker

- `make run`

####else

- `cd backend`
- `composer install`
- `php artisan migrate`
- `php artisan db:seed`

http://localhost:8080
