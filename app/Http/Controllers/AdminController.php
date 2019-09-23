<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class AdminController extends Controller{

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('role:admin');
  }

  public function index(Request $request){
    $users = User::all();
    return view('admin.usuarios', ["users"=>$users]);
  }

  public function nuevousuario(){
    return view('admin.nuevousuario');
  }

  public function guardarsuario(Request $request){
    $validatedData = $request->validate([
      'name' => ['required', 'string', 'max:255', 'unique:users'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8'],
    ], [
      'required' => 'El campo es requerido.',
      'email' => 'Email incorrecto',
      'password.min'    => 'La contraseña debe tener por lo menos :min caracteres',
    ]);

    $user = User::create([
      'name' => $request['name'],
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
    ]);
    $user->roles()->attach(Role::where('name', 'user')->first());

    return redirect()->route('admin.usuarios');
  }

}
