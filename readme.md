# Administración de usuarios en Laravel 6

## Requerimientos
* PHP >= 7.2.0
* Laravel >= 6.x
* Composer
* Git
* MySQL
* Node.js

## Instalación

* `git clone https://github.com/GuxMartin/laravel6-usuarios.git laravel6-usuarios`
* `cd laravel6-usuarios`
* `composer install`
* `cp .env.example .env`
* `php artisan key:generate`
*  Agrega los datos de conexión a la base de datos en *.env*
* `php artisan migrate`
* `php artisan db:seed`
* `php artisan serve` crear servior en http://localhost:8080/

## Creación del proyecto
```
# Creación del proyecto
$ composer create-project --prefer-dist laravel/laravel laravel6-usuarios

# Instalación de los componentes de autentificación
$ composer require laravel/ui
$ php artisan ui vue --auth
$ npm install && npm run dev
$ php artisan migrate
```
