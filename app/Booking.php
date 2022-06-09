<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\User;
use App\Rating;
use DB;
use Auth;
use App\CancelRequest;
class Booking extends Model
{
  
    protected $table = "bookings";
  
  
  
    protected $primaryKey = "id";
  
  
    protected $appends = ['artist_url','client_url'];
    
    public function getArtistUrlAttribute(){
        return asset('uploads/artist');
    }
    public function getClientUrlAttribute(){
        return asset('uploads/client');
    }
  
    protected $fillable = ['customer_id','artist_id','booking_for','distance_range_price','address','city','zipcode','phone_no','prefer_type','how_many','number_of_male','number_of_female','services','title','description','date','from','to','card_id','status','total_amt','payment_token','latitude','longitude'];
    
    
    public function getServicesAttribute($value){
        return ($value)? json_decode($value): null;
    }
 
    
    public function user_details(){
        return $this->hasOne(User::class, 'id', 'artist_id')->select('id', 'fname', 'lname','email', 'profile_picture','phonecode','mobile_no','latitude','longitude');
    }
    
    public function client_details(){
        return $this->hasOne(User::class, 'id', 'customer_id')->select('id', 'fname', 'lname','email', 'profile_picture');
    }
    
    public function customer_details(){
        return $this->hasOne(User::class, 'id', 'customer_id')->select('id', 'fname', 'lname','email', 'profile_picture');
    }
    
    // Below code is ot fetch ratings in client details by id
    public function ClientRating(){
        return $this->hasOne(Rating::class,'activity_id')->select('id','activity_id','rating_by','ratings as rating','reviews', DB::raw('FORMAT(avg(ratings),1) as rating'))->where('rating_to', Auth::id());
    }
    
    public function RatingByClient(){
        return $this->hasOne(Rating::class,'activity_id')->select('id','activity_id','rating_by','ratings as rating','reviews', DB::raw('FORMAT(avg(ratings),1) as rating'),'created_at')->where('rating_to', Auth::id());
    }
   
 
   
    
    // Bellow code is for to fetch Artist avg ratings on client side
    public function AtistAvgRating(){
        return $this->hasOne(Rating::class, 'rating_to', 'artist_id')->select('id','rating_to',DB::raw(' FORMAT(avg(ratings),1) as rating'), DB::raw('COUNT(reviews) as review_count'));
    }
    public function ClientAvgRating(){
        return $this->hasOne(Rating::class, 'rating_to', 'customer_id')->select('id','rating_to',DB::raw(' FORMAT(avg(ratings),1) as rating'), DB::raw('COUNT(reviews) as review_count'));
    }
    
    public function user_rating(){
        return $this->hasOne(Rating::class,'rating_to','artist_id')->select('id','rating_to',DB::raw('FORMAT(avg(ratings),1) as rating'), DB::raw('COUNT(reviews) as reviews'),'reviews');
    }
    
 
    
    public function client_rating(){
        return $this->hasOne(Rating::class,'rating_to','customer_id')->select('id','rating_to',DB::raw('FORMAT(avg(ratings),1) as rating'), DB::raw('COUNT(reviews) as reviews'),'reviews');
    }
    
    // Below code is using for show cancel note  in booking details by id api
    public function CancelNote(){
        return $this->hasOne(CancelRequest::class,'booking_id')->select('booking_id', 'note','cancel_by');
    }
    
    public function OfferDetails(){
        return $this->hasOne(\App\ClientDiscount::class,'user_id', 'customer_id' )->select('id','user_id','percentage','used_amt')->latest()->limit(1);
    }
}
