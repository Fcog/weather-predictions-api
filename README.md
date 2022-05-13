# Weather API


## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up` (the logs will be displayed in the current shell)
4. Enter container `docker-compose exec php /bin/ash`
5. Run `composer install`
6. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
7. Run `docker-compose down --remove-orphans` to stop the Docker containers.


## Endpoint

https://localhost/api/weather/{city}?date={Y-m-d}

Examples:

https://localhost/api/weather/amsterdam

https://localhost/api/weather/amsterdam?date=2022-12-15

## Run Tests

1. Enter container `docker-compose exec php /bin/ash`
2. Run `php bin/phpunit`
