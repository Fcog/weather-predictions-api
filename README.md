# Weather API

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up` (the logs will be displayed in the current shell)
4. Enter container `docker-compose exec php /bin/ash`
5. Run `composer install`
6. Run `php bin/console app:collect-data` to get the API mock data in the DB
7. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
8. Run `docker-compose down --remove-orphans` to stop the Docker containers.


## Endpoint

https://localhost/api/weather/{city}?date={Y-m-d}&scale={scale}

Examples:

https://localhost/api/weather/amsterdam

https://localhost/api/weather/amsterdam?date=2022-12-15

https://localhost/api/weather/amsterdam?scale=fahrenheit

## Run Tests

1. Enter container `docker-compose exec php /bin/ash`
2. Run `php bin/phpunit`


# Assumptions

- For simplicity, temperature doesn't support decimals
- temperature is saved as Celsius in the DB
- Each partner has its own response schema
- On production, the ApiDataCollectionService would run periodically using a worker or cron
- In Dev, the ApiDataCollectionService mocks the APIs with the source data files

## UML Diagrams

- [Class diagram Lucid link](https://lucid.app/lucidchart/fb258ee5-97f3-4407-b558-62fc603de8e2/edit?invitationId=inv_d1e4e58a-50f1-45e3-8da2-6346705cdad0)
