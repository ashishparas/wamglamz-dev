<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use \App\Subcategory;
class ArtistSchedule extends Model
{
    
    protected $table = "artist_schedule";
    
    
    
    
    
    protected $primaryKey = "id";
    
    
    protected $fillable = ['user_id','schedule','status'];
    
    
    public function getScheduleAttribute($value){
        return  json_decode($value);
    }
    
    
   
    
}
