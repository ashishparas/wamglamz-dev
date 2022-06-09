<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ContactUs extends Model
{
    
    protected $table = 'contact_us';
    
    
    protected $primaryKey = 'id';
    
    
    protected $fillable = ['user_id','name', 'email', 'subject','message','created_at','updated_at'];
    
}
