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

Route::prefix('admin')->group(function() {
  Route::prefix('usuarios')->group(function() {
    Route::get('/', 'AdminController@index')->name('admin.usuarios');
    Route::get('/create', 'AdminController@usuario')->name('admin.usuarios.create');
    Route::post('/', 'AdminController@store')->name('admin.usuarios.store');
    Route::get('/{id}', 'AdminController@show')->name('admin.usuarios.show');
    Route::get('/{id}/edit', 'AdminController@usuarioeditar')->name('admin.usuarios.edit');
    Route::put('/{id}', 'AdminController@usuarioupdate')->name('admin.usuarios.update');
  });
});
