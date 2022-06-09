<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    
    protected $table = "user_chat";
    
    
    
    protected $fillable = ['roomID','source_user_id','target_user_id','	message','	status','MessageType','modified_on','created_on'];
    
    
    
    
    protected $primarykey ="id";
}
