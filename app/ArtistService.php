<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Main_category;
use App\Subcategory;
use App\Favourite;
use App\Service;
use App\Rating;
use Auth;
use DB;
class ArtistService extends Model{
    
   use LogsActivity; 
    
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artist_services';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['artist_id','main_category_id','service_id', 'sub_category_id','price', 'status'];

    

    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
     
     protected $appends = ['ratings'];
     
     public function getRatingsAttribute(){
      
        $value = Rating::where('rating_to', $this->artist_id)->avg('ratings');
        return ($value === null)? '0': number_format($value,1); 
     }
    

    
    public function getGenderAttribute($value){
        return ($value == '1')?'women':'men';
    } 
    
    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }
  

 
    
    public function category(){
       return $this->hasMany(Main_category::class, 'id', 'main_category_id');
    }
    public function main_category(){
       return $this->hasOne(Main_category::class, 'id', 'main_category_id');
    }
    
    
    public function getRatingAttributes(){
        return $this->ratings->average('rating');
    }
    
   
    public function UserDetails(){
     return $this->hasOne(\App\User::class,'id', 'user_id')->select('id','fname','lname','email','profile_picture','zipcode');
    }
    
    public function favourite(){
        return $this->hasOne(Favourite::class,'like_to','artist_id')->select('like_to','like_by','status')->where('like_by', Auth::id());
    }
    
     public function artist_services(){
           return $this->hasOne(Main_category::class, 'id', 'main_category_id');
     }
     

     public function ArtistSubCategory(){
        return $this->hasOne(Subcategory::class, 'id', 'sub_category_id')->select('id','category_id','title');
    }
    
    public function SubCategory(){
        return $this->hasOne(Main_category::class, 'id', 'main_category_id')->with('artist_sub_category');
    }
    

    
   

}
