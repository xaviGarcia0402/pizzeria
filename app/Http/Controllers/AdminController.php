<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class AdminController extends Controller{

  private $errores;

  public function __construct(){
    $this->middleware('auth');
    $this->middleware('role:admin');
    $this->errores = [
      'required' => 'El campo es requerido.',
      'email' => 'Email incorrecto',
      'password.min'    => 'La contraseña debe tener por lo menos :min caracteres',
    ];
  }

  public function index(Request $request){
    $users = User::all();
    return view('admin.usuarios', ["users"=>$users]);
  }

  public function usuario(){
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
    return redirect()->route('admin.usuarios');
  }

  public function show(){
    return "Show";
  }

  public function usuarioeditar($id){
    $user = User::findOrFail($id);
    return view('admin.usuario_form', ["modo" => "editar"])->withUser($user);
  }

  public function usuarioupdate(Request $request, $id){
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
    return redirect()->route('admin.usuarios');
  }

}
