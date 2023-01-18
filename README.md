<p align="center">
  <img src="https://i.imgur.com/HHKGW5a.png" />
</p>

## Overview

A simple project showcasing a fully dockerized Laravel project with Vue.js and nginx. Users can register and submit posts, along with tags.

## Running Locally

Note: Docker & Docker Compose are required for this project.

### URL

[http://localhost](http://localhost)

### Steps

Run `./setup.sh` from the root of the project, OR run the following steps individually:

1. In the root of the project, build the containers: `docker-compose up -d`

2. Copy the laravel environment files: `cp src/.env.example src/.env`

3. Run composer install: `docker-compose run --rm composer install`

4. Generate an application key: `docker-compose run --rm artisan key:generate`

5. Set permissions for good measure: `chmod 755 -R src/storage/ src/bootstrap/cache/`

6. Run migrations and seeding: `docker-compose run --rm artisan migrate && docker-compose run --rm artisan db:seed`

7. Run npm and build the front end: `docker-compose run --rm npm install && docker-compose run --rm npm run prod`

## Notes

- A user can either post messages anonymously or signed into an account

- Anonymous messages can't be edited or deleted once it is submitted

- A person can't sign up with the username "anonymous", as this is reserved by the system

- The only sort requirement was to have posts displayed by descending creation date

- Searching can be done based on date (month and year combo), by user, or by tag reference

## Testing

A Postman API call collection is included for manual testing: [graffiti-wall.postman_collection.json](/graffiti-wall.postman_collection.json)
