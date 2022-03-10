# Task Assignment App

This is a web application which help tranfer, assign and manage tasks between multiple agents.

# Requirements

Package requirement:

-   PHP 7.x
-   Composer 2.0
-   Laravel 8.x
-   MySQL (Installation with XAMPP/MySQL Installer)

# Usage

## 1. Install package

### 1.1 Install composer.phar if you don't have it.

Command to install composer is like this:

```
curl -sS https://getcomposer.org/installer | php
```

### 1.2 Using composer to install package:

```
php composer.phar install
```

### 1.3 Setup environment variables

Copy a version `.env.example` -> `.env`

### 1.4 Generate key for the project

```
php artisan key:generate
```

### 1.5 Run the server in development mode:

```
php artisan serve
```

## 2. Database - Migration

To generate database schema, you will need to run migration.

### 2.1 Create a database with the corresponding name in `.env` file

### 2.2 Generate database schema with this command:

```
php artisan migrate
```

### 2.3 Create a new migration file with this:

```
php artisan make:migration <migration_name>
```

Detail see [here](https://laravel.com/docs/8.x/migrations)

### 2.4 To run seed, run this command:

```
php artisan db:seed --class=DatabaseSeeder
```

This command will create Database for the project

## 3. Build up project:

This project have several environment for study purpose. We will go over several environment for this project

## 3.1 Development:

For development, we have some container to build up:
You can run by this command:

```
docker-compose -f docker-compose.dev.yml up
```

This environment includes these images:

-   php:7.4-fpm
-   nginx
-   mariadb (for test purpose only)
-   adminer (for access mariadb)
