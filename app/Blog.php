<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Blog extends Model
{
    use LogsActivity; 
    
   protected $table = "blogs";
   
   
   
   protected $primaryKey = "id";
   
   
   
   protected $fillable = ['user_id', 'title','description','photo'];
}
