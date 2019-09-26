<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

  public function users(){
    return $this->belongsToMany(User::class)->withTimestamps();
  }

  public function users_activos(){
    return $this->belongsToMany(User::class)
            ->where('activo', 1)
            ->withTimestamps();
  }

}
