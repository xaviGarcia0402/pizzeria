<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsuariosController extends Controller{

  private $errores;

  public function __construct(){
    $this->errores = [
      'required' => 'El campo es requerido.',
      'email' => 'Email incorrecto',
      'password.min'    => 'La contraseña debe tener por lo menos :min caracteres',
    ];
  }

  public function index(Request $request){
    $users = User::where('activo',1)->get();
    return view('admin.usuarios', ["users"=>$users]);
  }


  public function inactivos(){
    $users = User::where('activo',0)->get();
    return view('admin.usuarios', ["users"=>$users]);
  }


  public function cambiar_status(Request $request){
    $user = User::findOrFail($request['id']);
    if($user->activo != $request['activo']){ return 'Ya cambiaron el status'; }
    $user->activo = ! $user->activo;
    $user->save();
    return 'ok';
  }


  public function create(){
    return view('admin.usuario_form', ["modo" => "nuevo", "user" => new User()]);
  }

  public function store(Request $request){
    $request->validate([
      'name' => ['required', 'string', 'max:255', 'unique:users'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8'],
    ], $this->errores);

    $user = User::create([
      'name' => $request['name'],
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
    ]);
    $user->roles()->attach(Role::where('name', 'user')->first());
    return redirect()->route('usuarios.index');
  }

  public function show(){
    return "Show";
  }

  public function edit($id){
    $user = User::findOrFail($id);
    return view('admin.usuario_form', ["modo" => "editar"])->withUser($user);
  }

  public function update(Request $request, $id){
    $user = User::find($id);

    $validaciones = [
      'name' => ['required', 'string', 'max:255', 'unique:users,name,'.$id],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
    ];
    if(! empty($request['password'])){ $validaciones['password'] = ['required', 'string', 'min:8']; }
    $request->validate($validaciones, $this->errores);

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    if(! empty($request['password'])){ $user->password = Hash::make($request->input('password')); }

    $user->save();
    return redirect()->route('usuarios.index');
  }

}
