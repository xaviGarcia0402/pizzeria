<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function(){
  Route::get('/', 'ProfileController@index')->name('profile.index');
});// /group prefix=>profile

Route::group(['prefix' => 'admin', 'middleware' => ['auth','role:admin']], function(){
  Route::resource('usuarios', 'Admin\UsuariosController')->except([
    'show',
  ]);
  Route::get('usuarios/inactivos', 'Admin\UsuariosController@inactivos')->name('usuarios.inactivos');
  Route::post('usuarios/{usuario}', 'Admin\UsuariosController@restore')->name('usuarios.restore');

  Route::resource('roles', 'Admin\RolesController')->except([
    'show','destroy',
  ]);
  Route::get('roles/usuario/{usuario}', 'Admin\RolesController@rolesUsuario')->name('roles.usuario');
  Route::post('roles/agregarRolAUsuario', 'Admin\RolesController@agregarRolAUsuario')->name('roles.agregarRolAUsuario');
  Route::delete('roles/usuario', 'Admin\RolesController@quitarRolAUsuario')->name('roles.quitarRolAUsuario');
  Route::get('roles/usuariosConRol/{role}', 'Admin\RolesController@usuariosConRol')->where('role', '[0-9]+')->name('roles.usuariosConRol');

  Route::get('logs', 'Admin\LogsController@index')->name('logs.index');
});// /group prefix=>admin
