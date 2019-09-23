<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

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

  public function guardarsuario(){
    return "guardarsuario";
  }

}
