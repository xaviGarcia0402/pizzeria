<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class LogsController extends Controller{

  public function index(Request $request){
    $data = Activity::query();
    return
      Datatables::eloquent($data)
        ->addColumn('causer', function($log){
          $causer = '';
          if($log->causer){
            $causer = '<img class="border rounded" src="'.asset('storage/avatars/'.$log->causer->avatar).'" style="width: 30px" /> '.$log->causer->name;
          }
          return $causer;
        })
        ->addColumn('data', function($log){
          $data = '';
          if(count($log->changes) > 0){
            $data = '<button class="btn-data btn btn-info btn-sm" type="button" value="'.base64_encode( json_encode($log->changes) ).'">Data</button>';
          }
          return $data;
        })
        ->rawColumns(['causer', 'data'])
        ->make(true);
  }

}
