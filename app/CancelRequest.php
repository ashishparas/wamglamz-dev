<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class CancelRequest extends Model
{
  
   use LogsActivity;
   
  protected $table = "cancel_requests";
  
  
  
  protected $primaryKey = "id";
  
  
  
  protected $fillable = ['user_id','booking_id','cancel_by','note'];
  
}
