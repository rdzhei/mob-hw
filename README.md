# README

App to fetch & provide weather data from public API.

## Launch instructions:

1. Clone the project `$ git clone git@github.com:rdzhei/mob-hw.git`
2. `$ cd mob-hw`
3. `$ make coldstart` (assuming you are running an unix-based OS that's able to process Makefiles). In case of Windows, please install `make` or just run the commands one-by-one listed in the Makefile under `coldstart`

The app will be run on localhost:8080

Environment vars are already commited. They're not sensitive, it's okay. In real life they wouldn't be commited.

## OpenAPI

Auto-generated docs located in `./OpenApi/oa.yaml`

To re-generate the docs, do `$ ./vendor/bin/openapi src -o OpenApi/oa.yaml`

It's possible to autowire that script, but I didn't do it now.

## API

Two endpoints are available:
- `/stations`
- `/stations/{station_id}`

## Tests

To run the tests, execute the following command:

`$ php bin/phpunit`


    


