# Administración de usuarios en Laravel 6

## Requerimientos
* PHP >= 7.2.0
* Laravel >= 6.x
* Composer
* Git
* MySQL

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


### Proyecto basado en
https://medium.com/@cvallejo/autenticaci%C3%B3n-de-usuarios-y-roles-en-laravel-5-5-97ab59552d91
https://github.com/karoys/laravel-native-roles-auth

---

### Comandos usados para la creación del proyecto
```
$ composer create-project --prefer-dist laravel/laravel laravel6-usuarios
$ composer require laravel/ui
$ php artisan ui vue --auth
$ npm install && npm run dev
$ php artisan migrate
$ php artisan make:model Role -m
$ php artisan make:migration create_role_user_table
$ php artisan make:seeder RoleTableSeeder
$ php artisan migrate:refresh --seed
```
