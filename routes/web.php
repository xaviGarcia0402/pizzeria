<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','activo','role:admin']], function(){
  Route::resource('usuarios', 'Admin\UsuariosController')->except([
    'show', 'destroy'
  ]);
  Route::get('usuarios/inactivos', 'Admin\UsuariosController@inactivos')->name('usuarios.inactivos');
  Route::post('usuarios/cambiar_status', 'Admin\UsuariosController@cambiar_status');
});
