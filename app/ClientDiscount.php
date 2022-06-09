<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ClientDiscount extends Model
{
    //
    use LogsActivity;
    
    
    
    protected $table = "client_discounts";
    
    
    
    protected $primaryKey = "id";
    
    
    
    protected $fillable = ['user_id', 'percentage','type','used_amt'];
    
    
    
    
    
    
    
}
