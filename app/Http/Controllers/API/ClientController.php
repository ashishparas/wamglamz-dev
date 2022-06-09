<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use App\User;
use \App\Role;
use App\Payment;
use App\Plan;
use \App\Rating;
use App\Booking;
use Carbon\Carbon;
use App\ArtistService;
use Illuminate\Support\Facades\Mail;
use Hash;
use Stripe;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
class ClientController extends ApiController
{
   public $successStatus = 200;
   private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','mobile_verified','profile_picture','dob','gender','zipcode','description','experience','license_no','upload_id','type','status','latitude','longitude','token','custom_id','created_at','updated_at'];
   public function formatValidator($validator) {
        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors[0];
    }
    
    
    public static function imageUpload($file, $folder) {
        $path = public_path($folder);
        $name = time() . rand(1, 10) . $file->getClientOriginalName();
        $file->move($path, $name);
        $upload['image'] = $name;
        return $upload['image'];
    }
    
    

    public function Plans(request $request){
        
        $rules = ['subscription_type' => 'required|in:1,2','plan_name'=>'', 'duration'=>'', 'amount'=>''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            
            $input =  $request->all();
            $input['user_id'] = Auth::id();
            $plan = Plan::Create($input);
            
            $user = User::where('id',Auth::id())->update(['status' => '4']);
            return parent::success(['message' => 'Plan Selected!', 'plan'=> $plan]);
            
        } catch (\Execption  $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function ViewProfile(Request $request){
        
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->with(['user_avg_rating'])->first();
            $user['profile_picture'] = url('uploads/client/'.$user['profile_picture']);
            return parent::success(['message' => 'Profile viewed successfully', 'user' => $user,'base_url' => url('uploads/client')]);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    
    
   public  function UpdateProfile(Request  $request){
      $rules = ['fname'=>'required','lname' => 'required','phonecode' => 'required','mobile_no' =>'required', 'zipcode' => '', 'dob' => 'required','gender' => 'required','description'=>'','profile_picture'=> ''];
      $validateAttributtes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules),  false);
      if($validateAttributtes):
          return $validateAttributtes;
      endif;
      
      try{
          
            $input = $request->all();
           
            $model = new User();
           
            $user = new User();
              
            if(!empty($request->file('profile_picture'))):
                $file = $request->file('profile_picture');
                $profile_picture =  self::imageUpload($file, 'uploads/client');
                $input['profile_picture'] = $profile_picture;
            endif;  
              
                $user->where('id', Auth::id())->update($input);
           
           
            $userData = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            $userData['profile_picture'] = url('uploads/client/'.$userData['profile_picture']);
            return parent::success(['message'=>'Profile Updated successfully', 'user'=> $userData,'base_url' => url('uploads/client')]);
//            return parent::successCreated(['message' => 'Profile Created Successfully',  'user' => $user]);
       
 
      } catch (\Exception $ex){
          return parent::error($ex->getMessage());
      }
      
    } 
    
    public function ViewPaymentCards(Request $request){
        // dd(Auth::id());
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $cards = \App\Payment::where('user_id', Auth::id())->with('PromoCode')->get();
            return parent::success(['message' => 'Cards viewed successfully', 'cards' => $cards]);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    public function DeletePaymentCard(Request $request){
        $rules = ['card_id' =>'required|exists:payments,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $payment = Payment::find($input['card_id']);
            $payment->delete();
            return parent::success(['message'=> 'Card deleted successfully']);
        } catch (\Execption $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public  function Ratings(Request $request){
        $rules = ['booking_id'=> 'required','artist_id' => 'required','ratings' => 'required', 'reviews' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $input['activity_id'] = $request->post('booking_id');
            $input['rating_to'] = $request->post('artist_id');
            $input['rating_by'] = Auth::id();
         
            $model = new Rating();
            $model->Create($input);
            return parent::success(['message' => 'Rating submitted successfully']);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    public function ViewRatings(Request $request){
        $rules = [];
        // dd(Auth::id());
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
         try{
             $ratings = \App\Rating::where('rating_to', Auth::id())->with('user_details')->orderBy('created_at','DESC')->get();
             foreach($ratings as $key => $rating):
             
             if(Auth::user()->type == '2'):
                $ratings[$key]['base_url'] = url('uploads/client');
                 elseif(Auth::user()->type == '1'):
                     $ratings[$key]['base_url'] = url('uploads/artist');
                     endif;
                 $UserRatings = Rating::select('ratings')->where('rating_to', Auth::id())->where('rating_by', $rating['rating_by'])->first();
                 $ratings[$key]['ratings'] = $UserRatings;
                 endforeach;
             
             return parent::success(['message' => 'View ratings successfully', 'ratings' => $ratings]);
         } catch (\Exception $ex){
             return parent::error($ex->getMessage());
         }
    }
    
    
    public function CustomerHome(Request $request){
        $rules = ['type' => 'required|in:1,2'];
    
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
                $input = $request->all();
                $main_category = \App\Main_category::where('slug', $input['type'])->get();
            
            
            return parent::success(['message' => 'Category viewed successfully', 'category' => $main_category, 'base_url' => url('uploads/category')]);
            
        }catch(\Exception $ex){
            return parent::error($ex->getmessage());
            
        }
    }
    
    
    public function ViewSubCategories(Request $request){
        
        $rules = ['category_id'=> 'required|exists:subcategories,category_id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input = $request->all();
            $Subcategories = \App\Subcategory::where('category_id', $input['category_id'])->get();
         
            $data = [];
            foreach($Subcategories as $key => $sub_category):
                $id = $sub_category['id'];
                $category_id = $sub_category['category_id'];
                $ArtistServices =  ArtistService::where('sub_category_id', $id)->where('main_category_id', $category_id)->count();
                $Subcategories[$key]['artist'] = $ArtistServices;
                // if($ArtistServices == 0):
                   
                //     unset($Subcategories[$key]);
                //     endif;
            endforeach;
        //   $arr= array_values($Subcategories->toArray());
              
    

        return parent::success(['message' => 'Sub-Category view successfully', 'sub_category' => $Subcategories, 'base_url' => url('uploads/subcategory')]);
        }catch(\Exception $ex){
            return parent::error($ex->getmessage());
        }
    }
    
    public function ViewArtistServiceProfile(Request $request){
     
        $rules = ['sub_category_id' => 'required','category_id' => 'required','search' => '', 'price'=>'','distance'=>'','ratings' =>'', 'availabilities'=>'','ratings' => '','city'=> '','state'=>'', 'zipcode'=>'', 'latitude' => '', 'longitude' => ''];
        
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
                
        try{
            
            $input = $request->all();
            $id  = $input['sub_category_id'];
            $category_id = $input['category_id'];
            $search = $input['search'];
            
            
            
                            $UpdateUserlocation = User::findOrFail(Auth::id());
                            $UpdateUserlocation['latitude'] = $input['latitude'];
                            $UpdateUserlocation['longitude'] = $input['longitude'];
                            $UpdateUserlocation->save();
            
            if($search != ''):
                    // DB::enableQuerylog();
                $artists = \App\ArtistService::select('artist_services.*','users.name','users.fname','users.lname','users.email','users.profile_picture','users.zipcode','availabilities.shop_name')
                            ->join('users','artist_services.artist_id','=', 'users.id')
                            ->join('availabilities','artist_services.artist_id','=', 'availabilities.user_id')
                            ->where('artist_services.main_category_id', $category_id)
                            ->where('artist_services.sub_category_id', $id)
                            ->where(function ($query) use ($search) {
                                
                                    $query->where('availabilities.shop_name', 'like', "%".$search."%")
                                          ->orWhere('users.zipcode', 'like', "%".$search."%")
                                          ->orWhere('users.name', 'like', "%".$search."%");
                                          
                            })->with('favourite')->orderBy('id','DESC')->get();
                            // dd(DB::getQueryLog());
                            
            else:
                            // DB::enableQuerylog();
                            
                            
                            
                            $lat = ($input['latitude'])?$input['latitude']: Auth::User()->latitude;  //Auth::User()->latitude;
                            $lng = ($input['longitude'])? $input['longitude'] :Auth::User()->longitude; //Auth::User()->longitude;
                            // dd($lat);
                            $raw = DB::raw(' ROUND(( 6371 * acos( cos( radians(' . $lat . ') ) * 
                                cos( radians(users.latitude) ) * cos( radians(users.longitude) - radians(' . $lng . ') ) + 
                                sin( radians(' . $lat . ') ) *
                                sin( radians(users.latitude) ) ) ))  AS distance');
                            
                    
                            $artists = new \App\ArtistService();
                                   
                            $artists = $artists->select('artist_services.*','users.name','users.fname','users.lname','users.email','users.profile_picture','users.zipcode','availabilities.shop_name','availabilities.availability','availabilities.city', 'users.email','users.latitude','users.longitude',$raw);
                            $artists = $artists->join('users','artist_services.artist_id','=', 'users.id');
                            $artists = $artists->join('availabilities','artist_services.artist_id','=', 'availabilities.user_id');
                           
                            $artists = $artists->where('artist_services.main_category_id', $category_id);
                            $artists = $artists->where('artist_services.sub_category_id', $id);
                        
                            // if(isset($request->city)):
                            //     $artists = $artists->where('availabilities.city', $input['city']);
                               
                            // endif;
                            // if(isset($request->state)):
                            //     $artists = $artists->where('users.city', $input['state']);
                            // endif;
                            // if(isset($request->zipcode)):
                            //     $artists = $artists->where('users.zipcode', $input['zipcode']);
                            // endif;
                            if(isset($request->price)):
                                $price = explode(',',$request->price);
                              
                                // DB::enableQueryLog();
                                $artists = $artists->whereBetween('artist_services.price', [ (int)$price[0], (int)$price[1] ]);
                             
                            endif;
                            
                            if(isset($request->distance)):
                                    $distance = explode(',',$request->distance);
                                    $artists = $artists->havingBetween('distance', [$distance[0], $distance[1]]);
                            endif;
                                             
                            if(isset($request->availabilities) && $request->availabilities < 3):
                                    $artists = $artists->where('availabilities.availability', $request->availabilities);
                            endif;
                            
                            if(isset($request->ratings)):
                                    // $ratings = explode(",", $request->ratings);
                                    
                                    // if($ratings[0] == 0 && $ratings[1] == 5):
                                            // do nothing
                                        // else:
                                            $artist_ratings = round($request->ratings);
                                            $range = $artist_ratings + 0.5;
                                            $artists = $artists->addSelect(DB::raw('ROUND(AVG(ratings.ratings),2) as ratings'));
                                            $artists = $artists->join('ratings','artist_services.artist_id','=', 'ratings.rating_to');
                                            $artists = $artists->havingBetween( 'ratings', [$artist_ratings,  $range ] );

                                            // endif;
                            endif;
                          
                        // DB::enableQueryLog();
                            $artists = $artists->with('favourite')->orderBy('artist_services.id','DESC')->get(); 
                        
                        // dd(DB::getQueryLog($artists));
                        // dd($artists);
                        
                            foreach($artists as $key => $val):
                       
                                $artists[$key]['profile_picture'] = url('uploads/artist/'. $artists[$key]['profile_picture']);
                           
                            endforeach;
                            
                            // dd(DB::getQueryLog());
            endif;
            
            
            return parent::success(['message'=>'Artist view successfully','artist' => $artists, 'base_url' => url('uploads/artist')]);
        }catch(\Exception  $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function Appointment(Request $request){
        // dd(Auth::id());
        $rules = ['type' => 'required|in:1,2,3,4'];
        $validateAttribute = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttribute):
            return $validateAttribute;
        endif;
        
        try{
            $input = $request->all();
            $current_date = date('Y-m-d');
           $appointment = [];
           
         
          if($input['type'] =='1'):
            //  DB::enableQueryLog();
                 $appointment  = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('customer_id', Auth::id())->whereIn('status', ['0','1'])->where('job_status','0')->with(['user_details'])->orderBy('created_at', 'DESC')->get();
            // dd(DB::getQueryLog());
            elseif($input['type'] =='2'):
                $appointment  = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('customer_id', Auth::id())->where('status', '1')->where('job_status','1')->with(['user_details'])->orderBy('created_at', 'DESC')->get();
            elseif($input['type'] =='3'):
           
                $appointment = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('customer_id', Auth::id())->whereIn('status', ['0','1'])->where('job_status','2')->with(['user_details'])->orderBy('created_at', 'DESC')->get();
            elseif($input['type'] =='4'):
                $appointment = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status', 'job_status','created_at')->where('customer_id', Auth::id())->where('status', '1')->where('job_status','3')->with(['user_details'])->orderBy('created_at', 'DESC')->get();
            endif;
            foreach($appointment as $key =>  $apt):
                //   DB::enableQueryLog();
            $Ratings =     \App\Rating::select('id','rating_to',DB::raw('FORMAT(avg(ratings),1) as rating'), DB::raw('COUNT(reviews) as reviews'),'reviews')->where('rating_to', $apt->artist_id)->first();
            //   dd(DB::getQueryLog($Ratings));
                if(is_null($Ratings['rating']) === false):
                        $appointment[$key]['user_rating'] = $Ratings;
                    else:
                        $appointment[$key]['user_rating'] = null;
                        endif;
                
                endforeach;
            return parent::success(['message' => 'view appointments successfullly', 'appointment' => $appointment]);
            
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
        
    }
    
    
    public function ClientBookingStatus(Request $request){
    // dd(Auth::id());
        $rules = ['booking_id' => 'required','status' => 'required|in:1,3']; //1->for on going ,booking status 2-> for cancel 3 for completed
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
              
                $input = $request->all();   
                $BookingDetail = Booking::where('id', $input['booking_id'])->first();
                // dd($BookingDetail->toArray());
                $booking = Booking::where('id', $input['booking_id'])->update(['job_status' => $input['status']]); // uncomment when work done
                
     
                $fname = Auth::user()->fname;
                $lname = Auth::user()->lname;
                $userType = Auth::user()->type;
                $notificationType = '';
                $message = '';
                $title= '';
                if($input['status'] == '2'):
                    
                    $notificationType = "request_cancel";
                
                    $message = 'Your  appointment for '.$BookingDetail->date.' has been cancelled successfully ';
                    $title = 'Cancel Booking';
                    // DB::enableQueryLog();
                    $charge_id = \App\ChargePayment::select('user_id','charge_id','booking_id')->where('user_id', Auth::id())->where('booking_id',$input['booking_id'])->first();
                   
                     // cancel code start
                    $date = $BookingDetail['date'].' '.$BookingDetail['to'];
                    // dd($date);
                    $to = \Carbon\Carbon::parse(date('Y-m-d h:i a'));
                    $from = \Carbon\Carbon::parse($date);
                    $hours =  $to->diffInHours($from);
            //   $hours = 0;
                    $charge_amt = $BookingDetail->total_amt; //$BookingDetail->total_amt
                        if( $hours <= 24 && $hours > 12 ):
                        $Amt =  $charge_amt * 50 / 100;
                        $amtText = 'less or equal to 24 and greater then 12';
                            
                     
                        elseif( $hours <= 12 && $hours >= 1 ):
                            $Amt =  $charge_amt * 75 / 100;
                            $amtText= 'with in 12 hours';
                          
                        elseif( $hours === 0 ):
                            $Amt =  $charge_amt;
                            $amtText ='charging all amount';
                            
                        elseif( $hours > 24 ):
                            $Amt =  0;
                            $amtText ='no charges';
                       
                        endif;
                     
                     $refunded_amt =    round($BookingDetail->total_amt) - $Amt;
                        
                    // dd($amtText .': '. $refunded_amt);
                    // cancel code end
                //   dd($BookingDetail->total_amt);
                  if($refunded_amt > 0):
                    $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
                    $refund = $stripe->refunds->create([
                        'charge' => $charge_id['charge_id'],
                        'amount' => $refunded_amt*100
                    ]);
                    // dd($refund);
                    // else:
                    // dd('not refunding');    
                    endif;
                    
                    // sending text msg to Artist
                    $artist_detail = \App\User::select('id','mobile_no')->where('id',$BookingDetail->mobile_no)->first();
                
                    
                    if($BookingDetail->status === '1'):
                        parent::sendTextMessage($message,'9817405368'); //$artist_detail->mobile_no
                        $this->Notification($fname, $lname, $userType, $notificationType, $message, $title, Auth::id(), $BookingDetail['customer_id'] ,$BookingDetail['id'], $date=null,  $start_time=null);
                        endif;
                    
                
                elseif($input['status'] == '3'):
                    
                    $notificationType = "request_complete";
                    $message = " has completed your booking";
                    $title = 'Complete Booking';
                    $message = ' Booking completed successfully!';
                    $this->Notification($fname, $lname, $userType, $notificationType, $message, $title, Auth::id(), $BookingDetail['customer_id'] ,$BookingDetail['id'], $date=null,  $start_time=null);
                elseif($input['status'] == '1'):
                    
                    $notificationType = "request_ongoing";
                    $message = " has start  your booking";
                    $title = 'Booking On Going';
                    $message = ' Booking on Going successfully!';
                    $this->Notification($fname, $lname, $userType, $notificationType, $message, $title, Auth::id(), $BookingDetail['customer_id'] ,$BookingDetail['id'], $date=null,  $start_time=null);                
                    endif;
                // $query = DB::getQueryLog();
                    
                
                return parent::success(['message' => $message]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    
    
    
    public static function Notification($fname, $lname, $userType, $notificationType, $message, $title, $user_id, $receiver_id ,$booking_id, $date=null,  $start_time=null){
        $dataModel = [
                    'to' => $receiver_id,
                    'title' => $title,
                    'body'  => '@'.$fname.' '.$lname. $message,
                    'created_by' => $user_id,
                    'payload'     => array(
                        'notification' => array('title' => $title,'body'  => '@'.$fname.' '.$lname.' '.$message, 'booking_id' => $booking_id, 'type' => $notificationType, 'user_type' => $userType, 'fname' => $fname, 'lname' => $lname, 'date'=> $date, 'start_date'  => $start_time),
                        'data'         => array('title' => $title,'body'  => '@'.$fname.' '.$lname.' '.$message, 'booking_id' => $booking_id, 'type' => $notificationType, 'user_type' => $userType, 'fname' => $fname, 'lname' => $lname, 'date'=> $date, 'start_date'  => $start_time),
                )];
                parent::pushNotifications($dataModel, Auth::id(), $receiver_id, $saveNotification=true);
               
    }
    
    
 public function payload(Request $request){
    
     $dataModel = [
                    'to' => 1,
                    'title' => 'chck notification',
                    'body'  => 'duke accept you request',
                    'created_by' => 98,
                    'payload'     => array(
                        'notification' => array('title' => 'accept request','body'  => "duke accept your request", 'booking_id' => 38, 'type' => 'request_accept', 'user_type' => '', 'fname' => 'duke', 'lname' => 'walker', 'date'=> '2022-01-26', 'start_date'  => '2022-01-26'),
                        'data'         => array('title' => 'accept request','body'  => "duke accept your request", 'booking_id' => 38, 'type' => 'request_accept', 'user_type' => '', 'fname' => 'duke', 'lname' => 'walker', 'date'=> '2022-01-26', 'start_date'  => '2022-01-26'),
                )];
     
     
     
     parent::pushNotifications($dataModel, 97, 98, $saveNotification=true);
 }
    
    
    public function CheckScheduleAppointment(Request $request){
        // dd(Auth::id());
        $rules = ['date' => 'required','from' =>'required','to' => 'required','artist_id'=>'required','latitude'=>'','longitude' =>'', 'type' =>'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules,  array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                
                $input = $request->all();
               
                $bookings = Booking::where('customer_id', Auth::id())->where('date', $input['date'])->get();
                $artist = [];
                $availabilities =  \App\Availability::select('user_id','shop_name','address','city','zipcode', 'description','availability','distance_range_price')->where('user_id', $input['artist_id'])->first();
                $artist['availability'] = $availabilities;
                // dd($availabilities);
                
                // Start my code===============>
                if($input['type'] === '1'):
                    
                     $lat = $input['latitude'];
                    $lng = $input['longitude'];
                    $artist_distance = User::select( DB::raw(' ROUND(( 6371 * acos( cos( radians(' . $lat . ') ) * 
                                cos( radians(latitude) ) * cos( radians(longitude) - radians(' . $lng . ') ) + 
                                sin( radians(' . $lat . ') ) *
                                sin( radians(latitude) ) ) ))  AS distance'))->findOrFail($input['artist_id']);
                                // dd($input['artist_id']);
                            
                    // $artist['distance'] =  25;
                    $artist['distance'] =  $artist_distance['distance'];
                    // dd($artist['distance']);
                     if(is_array($availabilities['distance_range_price']) === true && empty($availabilities['distance_range_price']) !== true):
             
                if(is_null($availabilities['distance_range_price']) === false):
                    
                        $travel_count =   count($availabilities['distance_range_price']) -1;
                        $maxDist = $availabilities['distance_range_price'][$travel_count]->maxDist;
                        $maxPrice = $availabilities['distance_range_price'][$travel_count]->price;
                    endif;
             
                $trvel_distance_charges = '';
                if(isset($availabilities['distance_range_price'])):
                 
                     foreach($availabilities['distance_range_price'] as $distance_range):
                  
                        
                // print_r($artist['distance']  .' >= '. $distance_range->minDist   .' && '.  $artist['distance']  .' <= '.   $distance_range->maxDist);
                
                    if( $artist['distance']  >= $distance_range->minDist   &&  $artist['distance']  <=   $distance_range->maxDist ): 
                // dd('first');
                         $artist['travel_distance'] = (isset($distance_range->price))?$distance_range->price:'';
                         break;
                         
                    elseif($artist['distance'] > $maxDist ):     
                        // dd($artist['distance']  .' > '. $maxDist);
                         $artist['travel_distance'] = (isset($maxPrice))?$maxPrice:'';
                         break;
                          
                    endif; 
                  
                   
                    endforeach; //dd();
                     
                    
                    endif;
                    
               else:
                   
                $artist['travel_distance'] ='';
                
                endif;
                
                elseif($input['type'] === '2'):
                    
                     $artist['travel_distance'] ='';
                     
                    endif;
                   
                    
                // dd($artist['travel_distance']);
                // end my code=================>
                
                
                
                foreach($bookings as $booking):
                    
                    $client_from = strtotime($booking->date.' '.$booking->from);
                    $client_to =  strtotime($booking->date.' '.$booking->to);
                   
                    $time_from = Carbon::createFromFormat('h:i a', $input['from'])->subHours(1)->format('g:i A');
                    $time_to = Carbon::createFromFormat('h:i a', $input['to'])->addHours(1)->format('g:i A');
                    
                    $from_date = strtotime($input['date'].' '.$time_from);
                    $to_date = strtotime($input['date'].' '.$time_to);
                    
                    
                      $message='';
                    if( ($client_from >= $from_date) && ($client_from >= $from_date) ):
                          $message='Selected schedule not available';
                        
                          return response()->json(['status' => false, 'code' => 200, 'data' =>['data' => array('travelling_fee' => $artist['travel_distance'])], 'error' => $message], 200);
                       
                            else:
                                $message = "Schedule available";
                                  return parent::success(['message' => 'Selected schedule available', 'data'=> array('travelling_fee' => $artist['travel_distance'])]);
                              
                        endif;

                endforeach;
                return parent::success(['message' => 'Selected schedule available', 'data'=> array('travelling_fee' => $artist['travel_distance'])]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    
    
}
