# Dropea Project Test

## Pre-requirements
* php v8
* composer v2
* docker

## Getting started
* Clone this repository in you local machine
```sh
git clone 
```

* Install dependencies
```sh
composer install
```

* Copy .env.example (i.g. linux)
```sh
cp .env.example .env
```

* Generate key
```sh
php artisan key:generate
```

* Run sail
```sh
./vendor/bin/sail up
```

* Run migrations and seeders
```sh
./vendor/bin/sail artisan migrate:fresh --seed
```

* Server running on http://localhost

* Press Ctrl+C to stop the server

* Run the following command to call API and load data into database
```sh
./vendor/bin/sail artisan api:get-store-entities
```

* Run test
```sh
./vendor/bin/sail test
```

* In a browser o postman, enter the following endpoints
```sh
http://localhost/api/Animals
http://localhost/api/Security
```
## API Response
* __success__: true indicates that the API call was successful.
* The __"data"__ key contains a list of APIs related to the requested category.
* __api__: The name of the API.
* __description__: A description of what the API does.
* __link__: A link to the API's documentation.
* __category__: Information about the category the API belongs to (ID and name).
