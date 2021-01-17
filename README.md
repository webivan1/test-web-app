Test basic web application 
---

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

- `make init`
- `cd backend -> npm install && npm run dev`

http://localhost:8080

###Test

- `make test`
