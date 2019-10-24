<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\User;
use App\Role;

class UsuariosController extends Controller{

  private $errores;

  public function __construct(){
    $this->errores = [
      'required' => 'El campo es requerido.',
      'email' => 'Email incorrecto',
      'password.min' => 'La contraseña debe tener por lo menos :min caracteres',
    ];
  }

  public function index($activos = 1, Request $request){
    $activos = (int) $activos;
    $data = [
      "activos" => $activos,
    ];
    if ($request->ajax()){
      $data = $activos ? User::query() : User::onlyTrashed();
      return
        Datatables::eloquent($data)
          ->editColumn('name', function(User $user){
            return '<img class="border rounded" src="'.asset('storage/avatars/'.$user->avatar).'" style="width: 30px" /> '.$user->name;
          })
          ->addColumn('roles', function($user){
            $btn =
              '<a href="'.route('roles.usuario', ['usuario'=>$user->id]).'" class="btn btn-outline-secondary btn-sm btn-block border-0">'.
                $user->roles->count().' '.
                ($user->roles->count() == 1 ? 'Rol' : 'Roles').
              '</a>';
            return $btn;
          })
          ->addColumn('action', function($user){
            $btn =
              '<a href="'.route('usuarios.edit', ['usuario'=>$user->id]).'" class="btn btn-primary btn-sm btn-hover">Editar</a>'.
              '<button type="button" class="btn btn-status btn-light btn-sm btn-hover" title="'.($user->trashed() ? 'Restaurar' : 'Desactivar').'" data-id="'.$user->id.'" data-name="'.$user->name.'">'.
                '<i class="fa fa-fw fa-'.($user->trashed() ? 'arrow-up' : 'ban').'"></i>'.
              '</button>';
            return $btn;
          })
          ->setRowClass(function ($user) {
            return $user->trashed() ? 'table-warning' : '';
          })
          ->rawColumns(['name','roles','action'])
          ->make(true);
    }
    return view('admin.usuarios', $data);
  }// /index


  public function destroy(Request $request, $id){
    $user = User::findOrFail($id);
    $user->delete();
    return 'ok';
  }


  public function restore(Request $request, $id){
    $user = User::onlyTrashed()->findOrFail($id);
    $user->restore();
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
    $user = User::findOrFail($id);

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
