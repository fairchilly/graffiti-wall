# Thinkific Journal

TODO

### Other - Installation/Deployment Steps

Note: Docker & Docker Compose are required for this project.

1. In the root of the project, build the containers: `docker-compose up -d --build`

2. Copy the laravel environment files: `cp src/.env.example src/.env`

3. Run composer install: `docker-compose run --rm composer install`

4. Generate an application key: `docker-compose run --rm artisan key:generate`

5. Set permissions for good measure: `chmod 755 -R src/storage/ src/bootstrap/cache/`

6. Run migrations and seeding: `docker-compose run --rm artisan migrate && docker-compose run --rm artisan db:seed`

7. Run npm and build the front end: `docker-compose run --rm npm install && docker-compose run --rm npm run prod`
