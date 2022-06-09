<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Main_category;
use App\ArtistService;
use App\Subcategory;
use App\User;
use Auth;
class Service extends Model
{
   use LogsActivity; 
  
  protected $table = "services";
  
  
  protected $primaryKey = "id";
  
  
  protected $fillable = ['artist_id', 'category_id'];
  
  
  public function ArtistMainCategory(){
      return $this->hasMany(ArtistService::class, 'main_category_id', 'category_id')->select('id','artist_id','sub_category_id','main_category_id','price')->where('artist_id', Auth::id())->with('ArtistSubCategory');
  }
  
  public function CategoryName(){
      return $this->hasOne(Main_category::class, 'id', 'category_id')->select('id','title');
  }
  
//   public function MainCategory(){
//       return $this->ArtistMainCategory()->select('id','artist_id');
//   }
  
  
  
}
