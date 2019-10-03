<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Nota extends Model
{
  use LogsActivity;
  protected static $logAttributes = ['nombre','descripcion'];
  protected static $logOnlyDirty = true;
}
