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


## Por hacer
* Catálogo de perfiles de usuarios. Alta-baja-editar.
* Tabla para el registro de cambios (log)
* Que el usuario pueda editar sus datos y cambir su contraseña
* Avatar/foto de los usuarios
* Paginamiento de los usuarios/roles

### Proyecto basado en
https://medium.com/@cvallejo/autenticaci%C3%B3n-de-usuarios-y-roles-en-laravel-5-5-97ab59552d91
https://medium.com/@cvallejo/roles-usuarios-laravel-2e1c6123ad
https://github.com/karoys/laravel-native-roles-auth
https://medium.com/@cvallejo/middleware-roles-en-laravel-5-6-87541406426f

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
$ php artisan make:controller AdminController
$ php artisan make:middleware CheckRole
$ npm i font-awesome --save
$ php artisan make:controller Admin/RolesController --resource
```
