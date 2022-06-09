<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Subscription extends Model
{
    
     use LogsActivity; 
     
     
    protected $table = "subscriptions";
    
    
    
    protected $primaryKay = "id";
    
    
    
    
    protected $fillable = ['user_id','plan_id','product_id','price_id','amount','type','duration','created_on'];
    
    
}
