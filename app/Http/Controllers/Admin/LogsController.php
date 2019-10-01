<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogsController extends Controller{

  public function index(){
    $logs = Activity::orderBy("created_at","desc")->paginate(10);
    return view('admin.logs', ["logs" => $logs]);
  }

}
