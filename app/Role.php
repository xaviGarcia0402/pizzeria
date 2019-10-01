<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model{

  use LogsActivity;
  protected static $logAttributes = ['name','description'];
  protected static $logOnlyDirty = true;

  public function users(){
    return $this->belongsToMany(User::class)->withTimestamps();
  }

  protected $fillable = [
    'name', 'description',
  ];

}
