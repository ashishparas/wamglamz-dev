<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model {

    use LogsActivity;
//    use SoftDeletes;

    
    protected $table = "user_devices";
    
    
    
    protected $primaryKey = "id";
    
    
    protected $fillable = ['user_id', 'type', 'token'];
    
}
