# Administración de usuarios en Laravel 6

## Características
* Usuarios: creación/edición/desactivación/re-activación
* Roles: creación/edición
* Roles a usuarios: asignar/quitar
* Módulo de notas (Vue) solo accesible con rol "notas"
* Perfil del usuario: datos, foto y contraseña
* Logs: registro de sucesos
* Uso de DataTables

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
* `php artisan storage:link`
* Opcional: `php artisan serve` crear servior en http://localhost:8000/

## Usuario administrador
| Email | Contraseña |
|---|---|
| `admin@example.com` | `secret` |

## Instrucciones para desarrollo frontend
* `npm i`
* `npm run watch` o `npm run dev`


### Proyecto basado en
* https://medium.com/@cvallejo/autenticaci%C3%B3n-de-usuarios-y-roles-en-laravel-5-5-97ab59552d91
* https://medium.com/@cvallejo/roles-usuarios-laravel-2e1c6123ad
* https://github.com/karoys/laravel-native-roles-auth
* https://medium.com/@cvallejo/middleware-roles-en-laravel-5-6-87541406426f
* https://laraveldaily.com/save-users-last-login-time-ip-address/
* https://www.5balloons.info/upload-profile-picture-avatar-laravel-5-authentication/
* https://bluuweb.github.io/tutorial-laravel/vue/#componente-con-vue-js
* https://www.itsolutionstuff.com/post/laravel-58-datatables-tutorialexample.html
* https://bloggie.io/@jctan/laravel-datatable-installation
* https://datatables.yajrabox.com/

### Librerías externas usadas
* https://github.com/spatie/laravel-activitylog
* https://github.com/yajra/laravel-datatables

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
$ composer require spatie/laravel-activitylog
$ php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="migrations"
$ php artisan migrate
$ php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="config"
$ php artisan make:controller Admin/LogsController
$ php artisan make:controller ProfileController
$ php artisan storage:link
$ php artisan make:model Nota -m
$ php artisan make:controller NotaController --resource
$ composer require yajra/laravel-datatables-oracle:^9.0
$ php artisan vendor:publish --tag=datatables
$ npm install --save datatables.net-bs4
$ npm run dev
```
