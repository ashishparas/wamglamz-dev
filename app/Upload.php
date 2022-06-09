<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Upload extends Model
{
    
    protected $table = "uploads";
    
    
    protected $primaryKay = 'id';
    
    
    protected $fillable = ['user_id','post_id','type','uploads'];
    
}
