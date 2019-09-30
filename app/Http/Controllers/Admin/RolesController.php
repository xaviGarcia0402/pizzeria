<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;

class RolesController extends Controller{

  private $errores;

  public function __construct(){
    $this->errores = [
      'required' => 'El campo es requerido.',
    ];
  }


  public function index(){
    $data = [
      "roles" => Role::all(),
    ];
    return view('admin.roles', $data);
  }


  public function create(){
    return view('admin.rol_form', ["modo" => "nuevo", "rol" => new Role()]);
  }


  public function store(Request $request){
    $request->validate([
      'name' => ['required', 'string', 'max:255', 'unique:roles'],
    ], $this->errores);

    $user = Role::create([
      'name' => $request['name'],
      'description' => $request['description'],
    ]);
    return redirect()->route('roles.index');
  }


  public function show($id){
      //
  }


  public function edit($id){
    $role = Role::findOrFail($id);
    return view('admin.rol_form', ["modo" => "editar"])->withRol($role);
  }


  public function update(Request $request, $id){
    $rol = Role::findOrFail($id);

    $validaciones = [
      'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$id],
    ];
    $request->validate($validaciones, $this->errores);

    $rol->name = $request->input('name');
    $rol->description = $request->input('description');

    $rol->save();
    return redirect()->route('roles.index');
  }


  public function destroy($id){
      //
  }


  public function rolesUsuario($id){
    $user = \App\User::findOrFail($id);
    $data = [
      "user" => $user,
      "roles" => Role::get()->except($user->roles->modelKeys()),
    ];
    return view('admin.roles_usuario', $data);
  }


  public function agregarRolAUsuario(Request $request){
    sleep(1);
    $user = \App\User::findOrFail( $request->input('userId') );
    if(! $role = Role::where('id', $request->input('rolId'))->first() ){ return 'Rol no encontrado'; }
    if($user->roles->contains($role)){ return 'Rol anteriormente establecido. Recargar la página'; }
    $user->roles()->attach($role);
    return "ok";
  }

  public function quitarRolAUsuario(Request $request){
    $user = \App\User::findOrFail( $request->input('userId') );
    if(! $role = Role::where('id', $request->input('rolId'))->first() ){ return 'Rol no encontrado'; }
    if(! $user->roles->contains($role)){ return 'Rol anteriormente quitado. Recargar la página'; }
    $user->roles()->detach( $role->id );
    return "ok";
  }


  public function usuariosConRol($id){
    $rol = Role::findOrFail($id);
    $data = [
      "rol" => $rol,
      "users" => $rol->users()->orderBy('name')->get()
    ];
    return view('admin.roles_usuarios', $data);
  }
}
