<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth','role:admin']], function(){
  Route::resource('usuarios', 'Admin\UsuariosController')->except([
    'show',
  ]);
  Route::get('usuarios/inactivos', 'Admin\UsuariosController@inactivos')->name('usuarios.inactivos');
  Route::post('usuarios/{usuario}', 'Admin\UsuariosController@restore')->name('usuarios.restore');

  Route::resource('roles', 'Admin\RolesController');
});
