<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use App\User;
use \App\Role;
use App\Availability;
use App\Schedule;
use App\Main_category;
use App\ArtistService;
use App\ArtistSchedule;
use App\Service;
use App\Payment;
use App\Mail\ForgotPassword;
use App\Plan;
use App\Upload;
use App\Rating;
use App\Booking;
use Carbon\Carbon;
use Stripe;
use Illuminate\Support\Facades\Mail;
use Hash;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;

class ArtistController extends ApiController
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
        // $upload['image'] = $name;
        
        return $name;
    }
    
    
    public function Availability(Request $request){
    
        $rules = ['shop_name'=>'', 'address'=>'', 'city'=>'','zipcode'=>'','availabilities'=>'required' ,'description'=>'required','latitude'=> 'required','longitude' => 'required','distance_range_price' =>''];
        
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input = $request->all();
            $model = new Availability();
            
            $availability = [];
            if($input['availabilities'] == '1'):
                $data = [
                 'user_id'  =>   Auth::id(),
                 'availability' =>   $input['availabilities'],
                 'description'  =>  $input['description'],
                 'distance_range_price' => $input['distance_range_price']
                ];
               
                 $availabilityId =    $model->Create($data);
                 $availability = $model->where('id',$availabilityId->id)->first();
                 
            endif;
            if($input['availabilities'] == '2' || $input['availabilities'] == '3'):
               
            $data = [
                     'user_id'      =>   Auth::id(),
                     'shop_name'    =>   isset($input['shop_name'])? $input['shop_name']: '',
                     'address'      =>   isset($input['address'])?$input['address']:'',
                     'city'         =>   isset($input['city'])? $input['city']:'',
                     'zipcode'      =>   isset($input['zipcode'])?$input['zipcode']:'',
                     'availability' =>   isset($input['availabilities'])?$input['availabilities']: '',
                     'description'  =>   isset($input['description'])? $input['description']:'',
                     'distance_range_price' => $input['distance_range_price']
                ];
             
                $shopAvailabilityId =    $model->Create($data);
                $availability = $model->where('id',$shopAvailabilityId->id)->first();
            endif;
            
            $model = User::find(Auth::id());
            $update['status'] = '5';
            $update['latitude'] = $input['latitude'];
            $update['longitude'] = $input['longitude'];
            $model->fill($update);
            $model->save();
            $artist = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            
            return parent::success(['message' => 'Availabilities Added Successfully!','availability' => $availability, 'user' => $artist]);
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function ViewAvailability(Request $request){
        
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $availability = Availability::where('user_id', Auth::id())->first();
          
            $user_location = User::select('latitude','longitude')->where('id',Auth::id())->first();
              $availability['latitude'] = $user_location['latitude'];
               $availability['longitude'] = $user_location['longitude'];
        
            return parent::success(['availability' => $availability]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    
    public function EditAvailability(Request $request){
    //   dd(Auth::id());
        $rules = ['shop_name'=>'', 'address'=>'', 'city'=>'','zipcode'=>'','availabilities'=>'required' ,'description'=>'required','latitude' =>'required','longitude' => 'required', 'distance_range_price' =>''];
        
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input = $request->all();
            $model = new Availability();
           
            
            $availability = [];
            if($input['availabilities'] == '1'):
                $data = [
                 'shop_name'    => '',
                 'address'      => '',
                 'city'         => '',
                 'zipcode'      => '',
                 'availability' =>   $input['availabilities'],
                 'description'  =>  $input['description'],
                 'distance_range_price' => $input['distance_range_price']
                ];
                // dd($data);
               $model->where('user_id', Auth::id())->update($data);
              
            endif;
            if($input['availabilities'] == '2'):
                
                    $data = [
                     
                     'shop_name' => $input['shop_name'],
                     'address' => $input['address'],
                     'city' => $input['city'],
                     'zipcode' => $input['zipcode'],
                     'availability' =>   $input['availabilities'],
                     'description'  =>  $input['description']
                    ];
                    
                    $model->where('user_id', Auth::id())->update($data);

            
            endif;
            
            if($input['availabilities'] == '3'):
                
                    $data = [
                     
                     'shop_name' => $input['shop_name'],
                     'address' => $input['address'],
                     'city' => $input['city'],
                     'zipcode' => $input['zipcode'],
                     'availability' =>   $input['availabilities'],
                     'description'  =>  $input['description'],
                     'distance_range_price' => $input['distance_range_price']
                    ];
                    
                    $model->where('user_id', Auth::id())->update($data);

            
            endif;
            
                    $availability = $model->where('user_id', Auth::id())->first();
                    User::where('id', Auth::id())->update(['latitude' => $input['latitude'], 'longitude' => $input['longitude'] ]);
            
            return parent::success(['message' => 'Availabilities Edit Successfully!','availability' => $availability]);
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    public function Schedule_2(Request $request){
        
        $rules = ['days' => 'required','close'=> 'required','open_time'=> '', 'close_time'=>''];
        
        $ValidateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($ValidateAttributes):
            return $ValidateAttributes;
        endif;
        
        try{
            
            $input = $request->all();
            $data = [];
           
            if($input['days'] == 'all'):
                
                for($j=1; $j<=7; $j++):
                    
                    $day = $j;

                    switch ($day) {
                        case 1:
                            $data =[
                                'user_id'   => Auth::id(),
                                'days' => 'Sunday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                            Schedule::Create($data);
                            break;
                        case 2:
                            $data =[
                                'user_id'   => Auth::id(),
                                'days' => 'Monday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                            Schedule::Create($data);
                            break;
                        case 3:
                            $data =[
                                'user_id'   => Auth::id(),
                                'days' => 'Tuesday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                            Schedule::Create($data);
                            break;
                        case 4:
                              $data =[
                                'user_id'   => Auth::id(),
                                'days' => 'Wednesday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                              Schedule::Create($data);
                              break;
                        case 5:
                             $data =[
                                'user_id'   => Auth::id(),
                                'days' => 'Thursday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                                Schedule::Create($data); 
                              break;
                        case 6:
                             $data =[
                                'user_id'   => Auth::id(),
                                'days' => 'Friday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                                Schedule::Create($data); 
                              break;
                        case 7:
                            $data = [
                                'user_id' => Auth::id(),
                                'days' => 'Saturday',
                                'marked_close' => '0',
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                            ];
                                Schedule::Create($data);
                              break;
                          
                        default:
                            break;
                        }
                    
                endfor;
                
             else:
                 
                    $data =[
                                'user_id'   => Auth::id(),
                                'days' => ucfirst($input['days']),
                                'marked_close' => $input['close'],
                                'open_time' => $input['open_time'],
                                'close_time' =>$input['close_time']
                         ];
                     Schedule::Create($data);    
                 
            endif;
            $schedule = Schedule::select("id","user_id","days","marked_close","open_time","close_time","status","created_at","updated_at")->where('user_id', Auth::id())->get();
           return parent::success(['message'=> 'Schedule added','schedule'=> $schedule]);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    
    public function Schedule(Request $request){
        $rules = ['schedule' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            
        endif;
        
        try{
            $input = $request->all();
            $json = json_decode($input['schedule'], true);
           
            $input['user_id'] = Auth::id();
               
            \App\ArtistSchedule::Create($input);
            
                    User::where('id', Auth::id())->update(['status' => '6']);
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();   
        
        $schedule = \App\ArtistSchedule::where('user_id', Auth::id())->first();    
        return parent::success(['message' => 'Schedule added successfully','user'=> $user,'schedule' => $schedule]);
        }catch(\Exception $ex){
            return parent::error($ex->getmessage());
        }
        
    }
    
    
    public function EditSchedule(Request $request){
        $rules = ['schedule' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            
        endif;
        
        try{
            $input = $request->all();

            $ArtistSchedule = \App\ArtistSchedule::where('user_id', Auth::id())->update($input);
           
          
      
        $user =  User::select($this->LoginAttributes)->where('id', Auth::id())->first();       
        $schedule = \App\ArtistSchedule::where('user_id', Auth::id())->first();    
        return parent::success(['message' => 'Schedule update successfully','user' => $user,'schedule' => $schedule]);
        }catch(\Exception $ex){
            return parent::error($ex->getmessage());
        }
        
    }
    
    public function ViewSchedule(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $schedule = ArtistSchedule::where('user_id', Auth::id())->first();
            return parent::success(['message' => 'Schedule viewed successfully','schedule' => $schedule]);
        }catch(\Exception $ex){
            return parent::error($ex->getmessage());    
        }
        
    }
    
    public function DeleteSchedule(Request $request){
        $rules = ['id' => 'required|exists:schedules,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            
            $model = Schedule::findOrFail($input['id'])->delete();
          
            return parent::success(['message' => 'Schedule deleted successfully']);
            
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    public function ConfirmSchedule(Request $request){
        $rules = ['status'=>'required'];
        $ValidateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($ValidateAttributes):
            return $ValidateAttributes;
        endif;
        
        try{
            $input = $request->all();
            $model = Schedule::where('user_id',Auth::id())->update(['status'=>'1']);
            
            
            $Updateuser = User::where('id',Auth::id())->update(['status'=> '5']);
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
           
            return parent::success(['message'=> 'Schedule added', 'user' => $user]);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    
    public function Services(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
             $Mencategory = Main_category::where('slug','2')->with(['subCategory'])->get();
            $Maincategory = Main_category::where('slug','1')->with(['subCategory'])->get();
            return parent::success(['message' => 'Service added successfully', 'women' => $Maincategory,'men' => $Mencategory, 'base_url' => url('uploads/category')]); 
            
        }catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    public function MenServices(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $Maincategory = Main_category::where('slug','2')->with(['subCategory'])->get();
            return parent::success(['message' => 'Service added successfully', 'category' => $Maincategory, 'base_url' => url('uploads/category')]); 
            
        }catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    public function AddServices(Request $request){
     
        $rules = ['main_category_id'=>'required', 'sub_category_id' => 'required', 'price'=>'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input =  $request->all();
            $model = new ArtistService();
            
            $input['user_id'] = Auth::id();
            
            
            $ArtistServices = $model->Create($input);
            $service = $model->where('id', $ArtistServices->id)->with(['Services','SubCategory'])->first();
            return parent::success(['message'=> 'Service Added Successfully', 'service'=>$service ]);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function AddMenServices(Request $request){
     
        $rules = ['main_category_id'=>'required', 'sub_category_id' => 'required', 'price'=>'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input =  $request->all();
            $model = new ArtistService();
            
            $input['user_id'] = Auth::id();
            
            
            $ArtistServices = $model->Create($input);
            $service = $model->where('id', $ArtistServices->id)->with(['Services','SubCategory'])->first();
            return parent::success(['message'=> 'Service Added Successfully', 'service'=>$service ]);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    
    public function GetArtistSelectedServices(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $model = new ArtistService();
            $service = $model->where('artist_id', Auth::id())->where('status','1')->with(['main_category','SubCategory'])->get();
            return parent::success(['services'=> $service]);
        }catch(\Extention $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    
    public function AllServices(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $model = User::where('id', Auth::id())->update(['status'=>'6']);
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            return parent::success(['message' => 'Services Added Successfully','user' => $user]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    public function EditServices(Request $request){
        $rules = ['id' =>'required|exists:artist_services,id', 'price' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input = $request->all();
            ArtistService::findOrFail($input['id'])->update(['price' => $input['price']]);
            
            
            return parent::success(['message' => 'service edited successfully']);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function Payment(Request $request){
        $rules = ['name'=>'required','card_no'=>'required','zipcode'=>'required', 'expiry_month'=>'required', 'expiry_year'=>'required', 'cvv'=>'required', 'set_default'=>''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input =  $request->all();
            if($input['set_default'] == '1'):
                $input['status'] = '1';
            endif;
            $input['card_no'] = base64_encode($input['card_no']);
            $input['cvv'] = base64_encode($input['cvv']);
            $input['user_id'] = Auth::id();
            $payment = Payment::Create($input);
            $payment['card_no'] = base64_decode($payment['card_no']);
            $payment['cvv'] = base64_decode($payment['cvv']);
            $user = User::where('id',Auth::id())->update(['status' => '8']);
            $artist = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            return parent::success(['message' => 'Payment Added!', 'payment' => $payment, 'user' => $artist]);
            
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function ArtistPlan(request $request){
        $rules = ['subscription_type' => 'required|in:1,2','plan_name'=>'', 'duration'=>'', 'amount'=>''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input =  $request->all();
            $input['user_id'] = Auth::id();
            $plan = Plan::Create($input);
            
            $user = User::where('id',Auth::id())->update(['status' => '9']);
            $artist = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            return parent::success(['message' => 'Plan Selected!', 'plan'=> $plan, 'artist' => $artist]);
            
        } catch (\Execption  $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    public  function Ratings(Request $request){
        $rules = ['booking_id'=> 'required','client_id' => 'required','ratings' => 'required', 'reviews' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $input['rating_to'] = $request->post('client_id');
            $input['rating_by'] = Auth::id();
            $input['activity_id'] = $request->post('booking_id');
            $model = new Rating();
            $model->Create($input);
            return parent::success(['message' => 'Rating submitted successfully']);
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    public function UpdateProfile(Request $request){
        $user = User::findOrFail(Auth::id());
                if($user->get()->isEmpty()):
                parent::error('user not found');
                endif;
        $rules = ['profile_picture' => '','fname' => '', 'lname' => '','email'=>'','phonecode'=>'','mobile_no'=>'', 'zipcode'=>'','experience'=>'','license_no'=>''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input = $request->all();
            
            if(!empty($request->file('profile_picture'))):
                $file = $request->file('profile_picture');
          
             $upload_id =  self::imageUpload($file , 'uploads/artist');
             $input['profile_picture'] = $upload_id;
            endif; 
            
            
            
            if(!empty($request->file('upload_id'))):
                $file = $request->file('upload_id');
             
             $upload_id =  self::imageUpload($file , 'uploads/artist');
             $input['upload_id'] = $upload_id;
            endif;
            
   
            
            $input['name'] = $input['fname'].' '.$input['lname'];
            $user->fill($input);
            $user->save();
           return parent::success(['message' => 'Profile update successfully','user' => $user]);
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    public function posts(Request $request){
      
        $rules = ['type' => 'required', 'title' => 'required', 'description' => 'required', 'video' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
         try{
          
             $input = $request->all();
            
           
             
             $postData = [
                 'user_id' => Auth::id(),
                 'type'    => $input['type'],
                 'title'   => $input['title'],
                 'description' => $input['description']
                ];
           
             if($request->hasFile('video')):
                $file = $request->file('video');
                
                $profile_picture =  self::imageUpload($file, 'uploads/artist');   
                $postData['videos'] = $profile_picture;
               
            endif;
                
           $post =  \App\Post::Create($postData);
          
             
           
            // dd($request->hasFile('upload'));
                if($request->hasFile('upload')){
                    $files = $request->file('upload');
                   
                    $i = 0;
                        foreach ($files as $file) {
                        //  dd($file->getClientOriginalName());
                                $name = time(). $file->getClientOriginalName();
                 
                                $path = public_path('uploads/artist');
                                $file->move($path, $name);
                                $data = [
                                    'user_id' => Auth::id(),
                                    'post_id' => $post->id,
                                    'type'    => $post->type,
                                    'uploads' => $name
                                    ];
                                Upload::Create($data);
                                if($i >= 0):
                                    \App\Post::where('id', $post->id)->update(['upload' => $name]);
                                endif;
                                $i++;
                
                    }
            }
             return parent::success(['message' => 'post added successfully']);
         }catch(\Exception $ex){
             return parent::error($ex->getmessage());
         }
        
    }
    
    public function ViewPosts(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            
            $post = \App\Post::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
            
            return parent::success(['message' => 'Post View successfully', 'post' => $post, 'base_url' => url('uploads/artist')]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    public function PostById(Request $request){
        $rules = ['post_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            
        endif;
        
        try{
            $input = $request->all();
            $posts = \App\Upload::where('post_id', $input['post_id'])->get();
            
            return parent::success(['message' => 'View all post successfully', 'posts' => $posts, 'base_url' => url('uploads/artist')]);
            
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function DeletePost(Request $request){
        $rules = ['id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input = $request->all();
            
            $post = new \App\Post();
            $post = $post->findOrFail($input['id'])->delete();
       
            
            return parent::success(['message' => 'Post deleted successfully']);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    
    
    public function WomenServices(Request $request){    
        
        $rules= ['service' => 'required','status' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            
            $input = $request->all();
            $servies =  json_decode($input['service'], true);
           $all_subcategories = [];
           $all_category = [];
            foreach($servies as $service):
          array_push($all_category, $service['category_id']);
               $data = [
                   'artist_id' => Auth::id(),
                   'category_id' => $service['category_id']
                   ];
                
                   $services = Service::updateOrCreate($data, $data);
                   
                  foreach($service['sub_category'] as $subcategory):
                      array_push($all_subcategories, $subcategory['id']);
                       $sub_data = [
                                'artist_id' => Auth::id(),
                                'service_id' => $services->id,
                                'main_category_id' => $service['category_id'],
                                'sub_category_id' => $subcategory['id'],
                                'price'      => $subcategory['price']
                           ];
                        ArtistService::updateOrCreate(['artist_id' => Auth::id(), 'main_category_id' => $service['category_id'], 'sub_category_id' => $subcategory['id'],], $sub_data);
                    
                    endforeach;
                   
                
            endforeach;
            // dd($all_category);
            Service::where('artist_id', Auth::id())->whereNotIn('category_id', $all_category)->delete();
            ArtistService::where('artist_id', Auth::id())->whereNotIn('sub_category_id', $all_subcategories)->delete();
              
            $model = new \App\ArtistService();
            $service = $model->where('artist_id', Auth::id())->with(['category','SubCategory'])->get();
            
            if($input['status'] == '1'):
                $Updateuser = User::where('id',Auth::id())->update(['status' => '7']);
            endif;
            
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            return parent::success(['message' => 'added services successfully','user' => $user]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
        
    }
    
    
    
    public function ArtistDetailsById(Request $request){
        
        $rules = ['id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            
            $input = $request->all();
            
            $artist = User::select('id','fname','lname','email','profile_picture', 'experience', 'description','latitude','longitude')->where('id', $input['id'])->with(['favourite','schedule','reviews','user_post'])->first();
            //   dd($artist);
            // women service start Array
            $artist['profile_picture'] = url('uploads/artist/'.$artist['profile_picture']);
         //   dd($artist);
            $WomenServices = ArtistService::select('artist_services.sub_category_id',DB::raw('main_categories.title as category_title'),'subcategories.title','subcategories.image','subcategories.gender','artist_services.price')->where('artist_id', $input['id'])
            ->join('subcategories','subcategories.id','=','artist_services.sub_category_id')
            ->join('main_categories','main_categories.id','=','artist_services.main_category_id')
            ->where('subcategories.gender','1')
            ->get();
        
            // women services end array
            
             // men service start Array
            $menServices = ArtistService::select('artist_services.sub_category_id',DB::raw('main_categories.title as category_title'),'subcategories.title','subcategories.image','subcategories.gender','artist_services.price')->where('artist_id', $input['id'])
            ->join('subcategories','subcategories.id','=','artist_services.sub_category_id')
            ->join('main_categories','main_categories.id','=','artist_services.main_category_id')
            ->where('subcategories.gender','2')
            ->get();
            
             $all_services = array('women' => $WomenServices, 'men' => $menServices);
            $artist['services'] = $all_services;
             // men services end array
            $ratings = Rating::select(DB::raw('AVG(ratings) as ratings'), DB::raw('COUNT(reviews) as reviews'))-> where('rating_to', $artist->id)->first();
    
            $artist['ratings'] = number_format($ratings->ratings,1);
            $artist['review_count'] = $ratings->reviews;
         
            
            $availabilities =  \App\Availability::select('user_id','shop_name','address','city','zipcode', 'description','availability','distance_range_price')->where('user_id', $input['id'])->first();
            $artist['availability'] = $availabilities;
            
            
            
            
            $artist['social_links'] = \App\SocialLink::select('facebook', 'instagram')->where('user_id', $input['id'])->first();
            
            $lat = Auth::user()->latitude;
            $lng = Auth::user()->longitude;
        
            $artist_distance = User::select( DB::raw(' ROUND(( 6371 * acos( cos( radians(' . $lat . ') ) * 
                                cos( radians(latitude) ) * cos( radians(longitude) - radians(' . $lng . ') ) + 
                                sin( radians(' . $lat . ') ) *
                                sin( radians(latitude) ) ) ))  AS distance'))->findOrFail($input['id']);
           
            $artist['distance'] =  $artist_distance['distance'];
          
            
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
                   
                $artist['travel_distance'] ='0';
                
                endif;
              
            
            
            
            
            return parent::success(['message' => 'View details successfully', 'artist' => $artist, 'base_url' => url('uploads/artist')]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    public function Booking(Request $request){
    //   dd(Auth::user()->custom_id);
        $rules = ['artist_id'=>'required', 'booking_for'=>'required', 'distance_range_price' => '', 'address'=>'', 'city'=>'', 'zipcode'=>'', 'phone_no'=>'required', 'how_many'=>'', 'services' =>'required', 'title' =>'required','description' =>'required','date'=>'required','from' => 'required','to'=>'required','card_id'=>'required','prefer_type'=>'required','number_of_male'=> '', 'number_of_female' => '', 'payment_token' => 'required','offer' => 'required','total_amt' => 'required','latitide'=>'','longitude' => ''];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
          
            $input = $request->all();
            // dd($input['artist_id']);
            $input['customer_id'] = Auth::id();
           
            $booking = Booking::Create($input);
         
            $booking_data = Booking::where('id', $booking['id'])->with(['user_details','user_rating'])->first();
          
            $payment = \App\Payment::where('id', $input['card_id'])->update(['payment_token' => $input['payment_token']]);
          
            $clientOffer = \App\ClientDiscount::where('user_id', Auth::id())->first();
            if(!empty($clientOffer)):
                $ClientDiscount = \App\ClientDiscount::where('user_id', Auth::id())->update(['percentage' => '0','type' => 'used', 'used_amt' => $input['offer']]); 
                endif;
               
            
         
       
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

                $createCard = $stripe->customers->createSource(
                    // 'cus_Ks4tFIKWAVjQAu',
                    Auth::user()->custom_id,
                    ['source' => $input['payment_token']]
                    );
                
                
                
          $charge =  $stripe->charges->create([
                'amount' => $booking['total_amt'] *100,
                'currency' => 'usd',
                'customer' => Auth::user()->custom_id,//Auth::user()->custom_id,
                'source' =>   $createCard->id,
                'description' => 'Booked a Service',
                ]);
         
          
              $paymentCharge =   \App\ChargePayment::create([
                    'user_id'     => Auth::id(),
                    'booking_id'  => $booking['id'],
                    'charge_id'   => $charge->id,
                    'customer_id' => $charge->customer,
                    'card_id'     => $charge->payment_method,
                    'amount'      => $charge->amount,
                    'currency'    => $charge->currency,
                    'brand'        =>  $charge->payment_method_details->card->brand,
                    'network_status' => $charge->outcome->seller_message,
                    'receipt_url'  => $charge->receipt_url
                ]);
            

             $saveNotification=true;
             $dataModel = [
                    'to' => $input['artist_id'],
                    'title' => "Booking Request",
                    'body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' send you booking request',
                    'created_by' => Auth::id(),
                    'priority' => 'high',
                    'content_available' => true,
                    'payload'     => array(
                        'notification' => array('title' => 'Booking Request','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' send you booking request','booking_id' => $booking_data->id, 'type' => 'booking_request', 'user_type' => Auth::user()->type ,'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null, 'type' => 'booking_request'),
                        'data'         => array('title' => 'Booking Request','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' send you booking request','booking_id' => $booking_data->id, 'type' => 'booking_request', 'user_type' => Auth::user()->type ,'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null, 'type' => 'booking_request' ),
                )];
                
                $userToken = \App\UserDevice::where('user_id',$input['artist_id'])->first();
                if(!empty($userToken)):
                        parent::pushNotifications($dataModel, Auth::id(), $input['artist_id'], $saveNotification);    
                    endif;
                
                
         
            return parent::success(['message' => 'Booked successfully', 'booking' => $booking_data]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    public function ServicesByArtist(Request $request){
        $rules = ['id' => 'required'];
        $validateAttribute = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttribute):
            return $validateAttribute;
        endif;
        
        try{
            $input = $request->all();
            $WomanServices = ArtistService::select('artist_services.id','artist_services.main_category_id','artist_services.sub_category_id',DB::raw('main_categories.title as category_title'),'subcategories.id',DB::raw('subcategories. title as sub_category_title'),'subcategories.gender','artist_services.price')
                        ->where('artist_id', $input['id'])
                        ->where('subcategories.gender', '1')
                        ->join('main_categories', 'artist_services.main_category_id','=', 'main_categories.id')
                        ->join('subcategories', 'artist_services.sub_category_id','=', 'subcategories.id')
            ->get();
            
            $manServices = ArtistService::select('main_categories.id',DB::raw('main_categories.title as category_title'),'subcategories.id',DB::raw('subcategories. title as sub_category_title'),'subcategories.gender','artist_services.price')
                        ->where('artist_id', $input['id'])
                        ->where('subcategories.gender', '2')
                        ->join('main_categories', 'artist_services.main_category_id','=', 'main_categories.id')
                        ->join('subcategories', 'artist_services.sub_category_id','=', 'subcategories.id')
            ->get();
            $services = ['women' => $WomanServices, 'men'=> $manServices];
            return parent::success(['message' => 'Artist services view successully!', 'services' => $services]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function ArtistAllServices(Request $request){
      
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
            
            try{
                // ->with('artist_services','ArtistSubCategory')
                
                $services = Service::where('artist_id', Auth::id())->with('CategoryName','ArtistMainCategory')->get();
               
               
                return parent::success(['message' => 'View services successfully','services' => $services]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    public function ArtistAppointments(Request $request){
        // dd(Auth::id());
        $rules = [];
        $ValidateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($ValidateAttributes):
            return $ValidateAttributes;
        endif;
        try{
            // DB::enableQueryLog();
            $bookings =  Booking::select('id','customer_id','title','description','from','to','date')->where('artist_id',Auth::id())->where('status', '0')->with('customer_details')->orderBy('created_at','DESC')->get();
           
        //   dd(DB::getQueryLog());
            return parent::success(['message' => 'View Appointments successfully!','bookings' => $bookings]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function ViewBookingById(Request $request){
   
        $rules = ['booking_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                $input = $request->all();
               
                $booking = Booking::where('id', $request->booking_id)
                                    ->with('ClientAvgRating','RatingByClient','client_details','OfferDetails','CancelNote')
                                    ->orderBy('created_at', 'DESC')
                                    ->first();
               
                $charge = \App\ChargePayment::select('charge_id','brand', 'network_status')
                                            ->where('booking_id', $request->booking_id)
                                            ->first();
            //   dd($charge);
                $booking['transaction_id'] = $charge['charge_id'];
                $booking['method'] = $charge['brand'];
                $booking['message'] = $charge['network_status'];
             
                    $ratings = Rating::select('id',DB::raw('ratings as rating'),'reviews','created_at')
                                    ->where('activity_id', $booking->id)
                                    ->where('rating_by',$booking->artist_id)
                                    ->first();
                    $booking['rating_by_artist'] = $ratings;
                $availability = \App\Availability::select('shop_name','address','city','zipcode','description')
                                ->where('user_id',$booking->artist_id)
                                ->first();
                $booking['artist_availability'] = $availability;
                $payment = \App\Payment::where('user_id', $booking->artist_id)->first();
                $booking['artist_card_details'] =(!$payment)?0:1; 
                return parent::success(['message'=> 'Booking details view successfully!', 'booking' => $booking]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
        
    }
    
    
    
    public function SetDefaultPayment(Request $request)
    {
      
        $rules = ['card_id' => 'required|exists:payments,id','status' => 'required|in:0,1'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
           
            if($input['status'] == '1'){
                Payment::where('user_id', Auth::id())->update(['set_default' =>'0']);
               
            }
            
            Payment::where('id',$input['card_id'])->where('user_id', Auth::id())->update(['set_default' => '1']);
          
            $cards = Payment::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
           
            return parent::success(["Card set to default successfully!",'cards' => $cards]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
     public function ClientViewBookingById(Request $request){
//   dd(Auth::id());
        $rules = ['booking_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                $input = $request->all();
                // DB::enableQueryLog();
                $booking = Booking::where('id', $request->booking_id)->with(['AtistAvgRating','user_details','OfferDetails','CancelNote'])->orderBy('created_at', 'DESC')->first();
             
                $clientRatings = Rating::select('id','activity_id','rating_to','ratings as rating','reviews')->where('activity_id', $booking->id)->where('rating_to', $booking->artist_id)->where('rating_by', $booking->customer_id)->first();
               
                $booking['rating_by_client'] = $clientRatings;
                
                // DB::enableQueryLog();
                    $ratings = Rating::select('id','activity_id','rating_by','ratings as rating','reviews')->where('activity_id', $booking->id)->where('rating_by', $booking->artist_id)->where('rating_to', $booking->customer_id)->first();
                // dd(DB::getQuerylog());
                $booking['rating_by_artist'] = $ratings;
                
                $charge = \App\ChargePayment::select('charge_id','brand','network_status')->where('user_id', Auth::id())->where('booking_id', $input['booking_id'])->first();
                //  dd($charge);
                $booking['method'] = $charge['brand'];
                $booking['transaction_id'] = $charge['charge_id'];
                $booking['message'] = $charge['network_status'];
                
                $artist_availability = \App\Availability::select('shop_name','address', 'city','zipcode','availability')->where('user_id', $booking->artist_id)->first();
                $booking['artist_availability'] = $artist_availability;
                $booking['artist_availability']['latiude'] = $booking->user_details->latitude;
                $booking['artist_availability']['longitude'] = $booking->user_details->longitude;
                return parent::success(['message'=> 'Booking details view successfully!', 'booking' => $booking]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
        
    }
    
    
    
    public function AppointmentRequest(Request $request){
      
        $rules = ['booking_id' => 'required', 'status' => 'required|in:1,2,3'];
        
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                $input = $request->all();
                $detail = Booking::where('id', $input['booking_id'])->first();
             
                $message =  '';
                $dataModel = [];
                if($request->status === '1'):
                
                 $dataModel = [
                    'to' => $detail['customer_id'],
                    'title' => "Request Accepted",
                    'body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has Accepted your booking request',
                    'created_by' => Auth::id(),
                    'payload'     => array(
                        'notification' => array('title' => 'Request Accepted','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has accepted your booking request','booking_id' => $detail->id, 'type' => 'request_accept', 'user_type' => Auth::user()->type, 'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null),
                        'data'         => array('title' => 'Request Accepted','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has accepted your booking request','booking_id' => $detail->id, 'type' => 'request_accept', 'user_type' => Auth::user()->type, 'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null),
                )];    
                    
                    
                    
                    $message = 'Request Accepted Successfully!';
                    $text = '@'.Auth::user()->fname.' '.Auth::user()->lname.' has Accepted your booking request';
                    $ClientDetails = \App\User::where('id', $detail['customer_id'])->first();
                    // dd($ClientDetails->mobile_no); paste this after by tiwillio
                    parent::sendTextMessage($text, $ClientDetails->phonecode , $ClientDetails->mobile_no);
                    
                    elseif($request->status === '2'):
                    $saveNotification=true;
             $dataModel = [
                    'to' => $detail['customer_id'],
                    'title' => "Request Rejected",
                    'body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has Rejected your booking request',
                    'created_by' => Auth::id(),
                    'payload'     => array(
                        'notification' => array('title' => 'Request Rejected','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has rejected your booking request','booking_id' => $detail->id, 'type' => 'request_reject', 'user_type' => Auth::user()->type, 'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null),
                        'data'         => array('title' => 'Request Rejected','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has rejected your booking request','booking_id' => $detail->id, 'type' => 'request_reject', 'user_type' => Auth::user()->type, 'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null),
                )];
                        
                        
                         $message = 'Request Rejected Successfully!';
                elseif($request->status === '3'):
                            $message =  'Request Cancelled Successfully!';
                            endif;
        
                $booking = Booking::where('id',$request->booking_id)->update(['status' => $request->status]);
                
                $saveNotification=true;
             
                parent::pushNotifications($dataModel, Auth::id(), $detail['customer_id'], $saveNotification);
                
                return parent::success(['message' => $message]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
        
        
    }
    
    
    public function ScheduleAppontments(Request $request){
        
        $rules = ['status' => 'required|in:0,1,2,3'];
    
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                // dd(Auth::id());
                $message ='';
                $appointments =[];
                $input = $request->all();
                
                if($input['status'] == '0'):
                        $appointments = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('artist_id', Auth::id())->where('status', '1')->where('job_status', '0')->with(['client_details','client_rating'])->orderBy('created_at','DESC')->get();
                        $message ='View upcoming appointments successfully!';
                    
                elseif($input['status'] == '1'):
                        $appointments = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('artist_id', Auth::id())->where('status', '1')->where('job_status', '1')->with(['client_details','client_rating'])->orderBy('created_at','DESC')->get();
                        $message ='View on going appointments successfully!';
                    
                elseif($input['status'] == '2'):
                   
                        $appointments = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('artist_id', Auth::id())->where('job_status','2')->with(['client_details','client_rating'])->orderBy('created_at','DESC')->get();
                        $message ='View cancelled appointments successfully!';
                        
                elseif($input['status'] == '3'):
                            
                        $appointments = Booking::select('id','customer_id','artist_id','title','description','date','from','to','status','job_status','created_at')->where('artist_id', Auth::id())->where('status', '1')->where('job_status', '3')->with(['client_details','client_rating'])->orderBy('created_at','DESC')->get();
                        $message ='View completed appointments successfully!';
                         
                endif;
                return parent::success(['message' => $message, 'appointment' => $appointments]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    public function CancelRequest(Request $request){
        
        
        $rules = ['booking_id' => 'required','status' => 'required|in:2', 'note' => 'required'];
        
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules,  array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            
            $input = $request->all();
            $BookingDetails = Booking::where('id', $input['booking_id'])->first();
            
              
            $date = $BookingDetails['date'].' '. $BookingDetails['to'];
     
            
            
        
            
           
            $booking = Booking::where('id', $request->booking_id)->update(['job_status' => $request->status]);
            
        
         
            if($booking === 1):
            
                $input['user_id'] = Auth::id();
                $input['cancel_by']  = Auth::user()->type;
            
                \App\CancelRequest::create($input);
                
        // cancelation policy#################################
                $to = \Carbon\Carbon::parse(date('Y-m-d h:i a'));
                $from = \Carbon\Carbon::parse($date);
                $hours = $to->diffInHours($from);
               
                $data= [
                    'user_id' => $BookingDetails['customer_id'],
                    'type'    => 'booking_cancel',
                    ];
        
      
                if($hours <= 24 && $hours > 12):
                    $data['percentage'] = 20;
             
                elseif($hours <= 12 && $hours > 0):
                    $data['percentage'] = 35;
                  
                elseif( $BookingDetails['date'] < date('Y-m-d') ):
                    $data['percentage'] = 50;
               
                endif;
             
                
                \App\ClientDiscount::updateOrCreate(['user_id'=> $BookingDetails['customer_id'] ],  $data );
           
            
              $receiver_id = array();
                if(Auth::user()->type == '1'):
                    $receiver_id = $BookingDetails['artist_id'];
                    
                elseif(Auth::user()->type == '2'):
                    $receiver_id = $BookingDetails['customer_id'];
                
                endif;
                       
               
                $saveNotification = true;
                
                $dataModel = [
                    'to' => $receiver_id,
                    'title' => "Request Cancelled",
                    'body'  => 'We regret to inform you that your appointment for '.$BookingDetails->date.' has been cancelled due to the unavailability of  @'.Auth::user()->fname.' '.Auth::user()->lname,
                    'created_by' => Auth::id(),
                    'payload'     => array(
                        'notification' => array('title' => 'Request Cancelled','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has cancelled your booking request','booking_id' => $BookingDetails->id, 'type' => 'request_cancel', 'user_type' => Auth::user()->type,'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null),
                        'data'         => array('title' => 'Request Cancelled','body'  => '@'.Auth::user()->fname.' '.Auth::user()->lname.' has cancelled your booking request','booking_id' => $BookingDetails->id, 'type' => 'request_cancel', 'user_type' => Auth::user()->type,'fname' => Auth::user()->fname, 'lname' => Auth::user()->lname, 'date'=> null, 'start_date'  => null),
                )];
                
              
              
                
                parent::pushNotifications($dataModel, Auth::id(), $receiver_id, $saveNotification);
                
                $text='we regret to inform you that your appointment for '.$BookingDetails->date.' has been cancelled due to the unavailability of ('.Auth::user()->fname.' '.Auth::user()->lname.').';
                $Client_detail = \App\User::select('id','mobile_no','phonecode')->where('id',$receiver_id)->first();
                parent::sendTextMessage($text, $Client_detail->phonecode, $Client_detail->mobile_no);  // $Client_detail->mobile_no
                
                
                endif;
            return parent::success(['message' => 'Booking cancel successfully']);
        }catch(\Exception $ex){
            return parent::error($ex->getmessage());
        }
    }
    
   public function CheckAppointments(Request $request){
       
       $rules = [];
       $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
           return $validateAttributes;
           endif;
           
           try{
               
               $booking = Booking::select('id','customer_id','artist_id','date')->with('user_details')->get();
             
               return parent::success(['message' => 'Success!']);
           }catch(\Exception $ex){
             return parent::error($ex->getMessage());  
           }
       
   }
   
   public function TaxtMessage(Request $request){
       $rules = [];
       $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), 'false');
       
       if($validateAttributes):
           return $validateAttributes;
           endif;
           try{
               $message = "Hello this is test message from Wamglam";
               parent::sendTextMessage($message, '9817405368');
               return parent::success(['message' => 'message send successfully']);
           }catch(\Exception $ex){
               return parent::error($ex->getMessage());
           }
       
   }
    
    
}
