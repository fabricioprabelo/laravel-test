<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

This is a sample project using [Laravel](https://laravel.com/) framework based.

## Requirements

-   PHP 8.1+
-   Composer
-   NodeJS 18+
-   Docker Desktop or Docker Engine

## Instructions

For this project you will need **Docker Engine** or **Docker Desktop** previously installed in you environment computer. For more information abou **Docker** [click here](https://www.docker.com/).

### 1. Step

Install composer packages by executing command on terminal:

```sh
composer install
```

### 2. Step

Install node packages by executing command on terminal:

```sh
npm install or yarn install
```

### 3. Step

Build node by executing command on terminal:

```sh
npm run build or yarn build
```

### 4. Step

Build Docker compose environment by executing command on terminal:

```sh
./vendor/bin/sail build
```

### 5. Step

After finish docker build, execute the following command on terminal:

```sh
./vendor/bin/sail up -d
```

### 6. Step

After environment up successfully, execute the migrations on terminal:

```sh
./vendor/bin/sail php artisan migrate
```

### 7. Step

After run migrations database seeders executing the following command on terminal:

```sh
./vendor/bin/sail php artisan db:seed
```

### 8. Step

Now you can access the environment in you preferred browser by accessing [http://localhost/login](http://localhost/login) with the following credentials:

**E-mail:** admin@example.com

**Password:** password

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
