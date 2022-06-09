<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\User;
class Favourite extends Model
{
   
   protected $table = "favourites";
   
   
   protected $fillable = ['like_by','like_to','status']; 
   
   
   
   
   protected $primaryKey = "id";
   
   
   public function artist_details(){
       return $this->hasOne(User::class, 'id', 'like_to')->select('id','fname','lname','email','profile_picture')->with('user_rating');
   }
   
}
