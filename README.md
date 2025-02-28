## Requirement

- [Composer](https://getcomposer.org/).
- [PHP >= 8.2](https://www.php.net/).
- [MySql](https://www.mysql.com/).

## Instalation
- composer update
- set env
- php artisan migrate
- php artisan key:generate

## Running
- php artisan serve

## Setup With Docker
- docker-compose up -d --build
- docker-compose exec laravel-customer-api php artisan migrate
- running in port 8000

## Running With Docker
- docker-compose up -d
- running in port 8000
