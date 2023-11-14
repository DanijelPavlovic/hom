## Home Budget (Lumen PHP Framework)

### Getting started

1. Create an `.env` from `.env.example`
2. Run `composer install` command
3. Run `make db-start` command to build the database inside a docker container
4. Run `make migrations` command to create the tables inside the DB
5. Run `make start` to run start the app

<br>

> **Note:** To stop the DB container run the `make db-stop` command.

### Api Documentation

Open Postman and impor the postman collection located in the root directory

### Testing

> **Note:** If you wish to populate the databse with test data run the `make seed` command.
> <br> <br>
> This will generate a test user with the following credentials
> <br> <br> _Email:_ testUser@local.tbd <br> _Password:_ 123456

WIP

## Official Laravel Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
