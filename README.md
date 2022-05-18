# Strict SOLID implementation guidelines.

This repository is an example of strict implementation of SOLID princinple. It also includes up to date programming techniques like RequestValidation, ResponseCollection, Repository Pattern, Observer, Dependency Inversion, Unit Testing, swagger and many more.

This is a base code that ideally I want to implement on laravel projects. 

## Installation

Clone the repository 

```bash
git clone git@github.com:Damnval/base_code_laravel.git
```

## Install dependencies

Go to project folder and run 

```bash
composer install
```

## Development Setup

Create an .env file

```bash
cp .env.example .env
```

Create a key for laravel project

```bash
php artisan key:generate
```

## Create DataBase 

Go to your sql and create a DB named {yourDbName - based on .env}

## Setup DB credentials

DB_USERNAME={YOUR_DB_USERNAME}
DB_PASSWORD={YOUR_PASSWORD}

## Migrate database

```bash
php artisan migrate
```

## Serve project

```bash
php artisan serve
```

Go to browser and type http://localhost:8000/

## To Test project

```bash
php artisan test
```

## To Generate Swagger/OpenAPI Documentation 

```bash
php artisan l5-swagger:generate
```

Go to browser and open http://localhost:8000/api/documentation

### Coding Style

PSR-2 / SOLID / KISS
