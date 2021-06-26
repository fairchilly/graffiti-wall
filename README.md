# Thinkific Multi-User Journal Assignment

### Date Or Reflection

June 26, 2021

### Location of deployed application (not necessary for Junior Engineers)

http://167.172.145.138/

### Instructions to run assignment locally

Note: Docker & Docker Compose are required for this project.

1. In the root of the project, build the containers: `docker-compose up -d --build`

2. Copy the laravel environment files: `cp src/.env.example src/.env`

3. Run composer install: `docker-compose run --rm composer install`

4. Generate an application key: `docker-compose run --rm artisan key:generate`

5. Set permissions for good measure: `chmod 755 -R src/storage/ src/bootstrap/cache/`

6. Run migrations and seeding: `docker-compose run --rm artisan migrate && docker-compose run --rm artisan db:seed`

7. Run npm and build the front end: `docker-compose run --rm npm install && docker-compose run --rm npm run prod`

### Time spent

15 hours total (Approx 6 hours for core functionality, 9 hours for polishing)

### Assumptions made

-   A user can either post messages anonymously or signed into an account

-   Anonymous messages can't be edited or deleted once it is submitted

-   A person can't sign up with the username "anonymous", as this is reserved by the system

-   The only sort requirement was to have posts displayed by descending creation date

-   Tags weren't included as a requirement, but this was more of the "creative" side of my solution

-   There needed to be some ability to search, which can be done based on date (month and year combo), by user, or by tag reference

### Shortcuts/Compromises made

Due to time constraints, I would have implemented a few things differently:

-   Add caching
-   Implement Elasticsearch as a search engine
-   Add a queue structure to handle updates and have a cron job run in intervals to batch these updates to the database (to minimize the amount of calls made to the database)
-   I would have refactored the front end code to be a bit cleaner and make more re-usable components
-   I would add testing
-   I would have encrypted the passwords on the front end before sending them over HTTP to the API (for login and registration), I just ran out of time
-   I would have included a cookie discloure to the site, as they are used to store user information and json web tokens

### Assume your application will go into production...

#### 1) What would be your approach to ensuring the application is ready for production (testing)?

-   I would first document the system, as other developers will likely need to utilize this documentation in the future

-   Make unit tests for the back end API and functional browser tests for the front end

-   Depending on the team size, I would have testers run through predetermined user stories/scenarios to ensure functionality

-   I would make sure the client (if applicable) is satisfied with the product

#### 2) How would you ensure a smooth user experience as 1000’s of users start using your app simultaneously?

-   This is dependant on where the users are geographically located, and the actions they are taking within the application.
    -   If they are in different countries, sharding the database in different geographic areas will help alleviate any slow response times
    -   In addition, we could replicate the database and assign them to only perform read or write actions
    -   Load balancers can also be utilized to distribute the traffic equally among available servers

#### 3) What key steps would you take to ensure application security?

-   Never store plain text passwords in the database, they must always be encrypted with a strong hashing algorithm
-   Ensure the application is proteced against security attacks, such as SQL injection or XSS attacks (thankfully taken care of by more modern frameworks)
-   Develop a data backup policy to allow data redundancy in the event of any data loss

### What did you not include in your solution that you want us to know about? Were you short on time and not able to include something that you want us to know about? Please list it here so that we know that you considered it.

-   The route I took with this application was to split the front and backends (Vue and Laravel). This increases the complexity, and therefore time, it takes to complete the project. I went a little overboard with making the application too polished, which also resulted in a longer development time.

### Other information about your submission that you feel it's important that we know if applicable.

For anyone reviewing this solution and who is not familiar with Laravel + Vue applications, here are a few points of interest:

-   Controllers: `src/app/Http/Controllers`
-   Services (i.e. business logic): `src/app/Services`
-   Models: `src/app/Models`
-   Migrations: `src/database/migrations`
-   VueJS location: `src/resources/js`

I've also included a Postman API call collection that can be used for testing: `Thinkific Journal (Graffiti Wall).postman_collection.json`

### Your feedback on this technical challenge

Have feedback for how we could make this assignment better? Please let us know.
