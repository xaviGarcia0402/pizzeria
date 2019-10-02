<?php

namespace App;

use App\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable{
    use Notifiable;
    use SoftDeletes;

    use LogsActivity;
    protected static $logAttributes = ['name', 'email', 'avatar', 'deleted_at'];
    protected static $logOnlyDirty = true;

    public function authorizeRoles($roles){
      abort_unless($this->hasAnyRole($roles), 401);
      return true;
    }// /authorizeRoles


    public function hasAnyRole($roles){
      if (is_array($roles)) {
        foreach ($roles as $role) {
          if ($this->hasRole($role)){ return true; }
        }
      }
      else {
        if ($this->hasRole($roles)) { return true; }
      }
      return false;
    }// /hasAnyRole


    public function hasRole($role){
      if($this->roles()->where('name', $role)->first()) { return true; }
      return false;
    }// /hasRole


    public function roles(){
      return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
