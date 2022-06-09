<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Rating;
use App\Post;
use App\ArtistSchedule;
use App\ArtistService;
use App\Favourite;
use DB;
use Auth;
class User extends Authenticatable {

    use HasApiTokens,
        Notifiable,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','fname','lname', 'email', 'password',
        'profile_picture', 'dob', 'mobile_no','otp',
        'phonecode','zipcode','gender','mobile_verified',
        'description','type','status','latitude','longitude','experience','license_no','upload_id','facebook_id','google_id','apple_id','token','custom_id','email_otp'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  
    
    public function getexperienceAttribute($value) {

            return $value == null ? "" : $value;
    }
     public function getLicenseNoAttribute($value){
         return $value == null ? "": $value;
     }
     
   
    
    public function AauthAcessToken(){
    return $this->hasMany('\App\OauthAccessToken');
}

    public static function usersIdByPermissionName($name) {

        $permissions = \App\Permission::where('name', 'like', '%' . $name . '%')->get();
        if ($permissions->isEmpty())
            return [];
        $role = \DB::table('permission_role')->where('permission_id', $permissions->first()->id)->get();
        if ($role->isEmpty())
            return [];
        return \DB::table('role_user')->whereIN('role_id', $role->pluck('role_id'))->pluck('user_id')->toArray();
    }
    
    public function favourite(){
        return $this->hasOne(Favourite::class, 'like_to')->select('like_to','like_by','status')->where('like_by', Auth::id());
    }
    
    
 
    
    public function user_post(){
        return $this->hasMany(Post::class, 'user_id');
       
    }
    
    public function schedule(){
          return $this->hasOne(ArtistSchedule::class, 'user_id')->select('user_id','schedule');
        
    }
    
    public function services(){
        return $this->hasMany(ArtistService::class, 'user_id')->with('SubCategory')->select('user_id','sub_category_id', 'price');
    }
    
    public function reviews(){
        return $this->hasMany(Rating::class, 'rating_to')->select('rating_to','rating_by','reviews','created_at', DB::raw('CAST(ratings as DECIMAL(2,1)) as rating'))->with('user_details');
    }
    
    public function user_rating(){
        
        return $this->hasOne(Rating::class,'rating_to')->select('id','rating_to',DB::raw('FORMAT(avg(ratings),1) as rating'));
    }
    
    public function user_avg_rating(){
        
        return $this->hasOne(Rating::class,'rating_to')->select('id','rating_to',DB::raw('FORMAT(avg(ratings),1) as rating'), DB::raw('COUNT(reviews) as review'));
    }

    


}
