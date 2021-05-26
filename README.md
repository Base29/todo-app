<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

A simple Todo application developed using Laravel 8.x and VueJS. This application demostrates CRUD operations.

# Instructions

In order to run the application locally and test it, you need to follow the deployment steps mentioned below.

## Step 1

Clone the repo to your local machine.

```bash
$ git clone https://github.com/Base29/todo-app.git
```

## Step 2

Rename `.env.example` file to `.env` in the projects root folder.

```bash
$ mv .env.example .env
```

OR

```bash
$ cp .env.example .env
```

In your `.env` file declare the following variable.

```
FRONT_END_URL=http://localhost:8000
```

## Step 3

Add database credentials in to the `.env` file. You can use `PostgreSQL` or `MySQL/MariaDB`.

## Step 4

Run migrations.

```bash
$ php artisan migrate
```

## Step 5

Generate JWT secret key.

```bash
$ php artisan jwt:secret
```

## Step 6

Install JS libraries by running

```bash
$ npm install
```

## Step 7

Fire up the application by running the development server.

```bash
$ php artisan serve
```

AND

```bash
$ npm run dev
```

Access the application at <http://localhost:8000>

## Email Verification

In order to test email verification functionality we need to setup [MailHog](https://github.com/mailhog/MailHog) locally or we can setup a [MailTrap](https://mailtrap.io/) account.

## Optional

To generate bulk todo items please run the following command.

```bash
$ php artisan db:seed --class=TodoItemSeeder
```

Above command will seed the `todo_items` table with 40 records, Which can be used to test out infinite loading feature.
