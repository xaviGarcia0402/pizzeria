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
}
