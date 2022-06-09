<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use App\User;
use Helper;
use \App\Role;
use Carbon\Carbon;
use App\Subscription;
use App\Payment;
use Stripe;
use App\Notification;
use App\Mail\ForgotPassword;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Hash;
use App;
use App\SocialLink;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;

class AuthController extends ApiController {

    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','mobile_verified','profile_picture','dob','gender','zipcode','description','experience','license_no','upload_id','type','status','latitude','longitude','token','custom_id','created_at','updated_at'];
//    public static $_mediaBasePath = 'uploads/users/';
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
    

    public function getMetaContent(Request $request) {

        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $metaContent = \App\Metum::where('name', 'LIKE', "%$keyword%")->get();
        } else {
            $metaContent = \App\Metum::get();
        }


        if (!$metaContent->isEmpty()) {
            return parent::success($metaContent, 200);
        } else {
            return parent::error('No Meta Content Found', 500);
        }
    }

    
    



    public function login(Request $request) {
        try {
            $rules = ['email' => 'required', 'password' => 'required'];
            
            $rules = array_merge($this->requiredParams, $rules);
            $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
            if ($validateAttributes):
              
                return $validateAttributes;
            endif;

            
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])):
                
                $input = $request->all();
                // $latitude  = $input['latitude'];
                // $longitude = $input['longitude'];
                
                // $UpdateData = \App\User::where('id', Auth::user()->id)->update(['latitude' => $latitude, 'longitude' => $longitude]); 
                
                $user = \App\User::select($this->LoginAttributes)->find(Auth::user()->id);
                $user->save();
                
              if($user->status == '1'):
             
                  parent::sendOTPUser($user);
                  endif;
                
                
                $token = $user->createToken('MyApp')->accessToken;  
               
                parent::addUserDeviceData($user, $request);
              
                return parent::success(['message' => 'Login Successfully-1', 'token' => $token, 'user' => $user]);
            else:
                
                return parent::error("User credentials doesn't matched");
            endif;
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function Social_login(Request $request){
        
        $rules = ['email'=> '','social_id' =>'required', 'name'=> '', 'type'=> 'required'];
        $rules = array_merge($this->requiredParams, $rules);
      
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
            try{
                
                $input = $request->all();
                
                $field = array();
                $facebook_id = ''; 
                $google_id = '';
                $apple_id = '';
                $social_source  =  strtolower($input['social_type']); 
                $social_id      =  $input['social_id'];  
                
                if( $social_source == 'facebook' || $social_source == 'google' || $social_source == 'apple' ) {
                
                    $field[ $social_source.'_id' ] = $social_id;
                
                }
             
                // dd($field);
                // DB::enableQueryLog();
                $current_user_id = User::select('id')->where($field)->first();
                // dd($current_user_id);
                // dd(DB::getQueryLog($current_user_id));
    			if(is_null($current_user_id) !== true ) {
    		
    			    $user = User::where('id', $current_user_id->id)->first();
    			    if(!empty($user->status == '1')):
    			            parent::sendOTPUser($user);    
    			        endif;
    			    
    			    if($user->type !== $input['type']):
    			        $typ = ($user->type === '1')? 'client':'artist';
    			        return parent::error('This account already registered with '.$typ);
    			        endif;
    		        $token = $user->createToken('MyApp')->accessToken;
    				return parent::success(['message'=> 'Login successfully-2','token' => $token, 'user' => $user]);
    			    
    			} else {
    
    			    $user = array ();
    				if ( isset ( $input['email'] ) && ! empty ( $input['email'] ) ) {
    				    
    				    // mycode
                    
                        $input['email'] = $request->email;
                   
                        $rules = array('email' => 'unique:users,email'); //
                        
                        $validator = Validator::make($input, $rules);
                        
                        if ($validator->fails()) {
                             
                            $current_user_id = User::select('*')->where('email', $input['email'])->first();
                            User::where('id', $current_user_id->id)->update($field);
                            $userData = User::select('*')->where('email', $input['email'])->first();
                            $token = $current_user_id->createToken('MyApp')->accessToken;
                            return parent::success(['message' => 'login successfully', 'token' => $token,'user' => $userData]);
                        }
                        else {
                           
                            $field['email']  = $input['email'];
                            $field['name']   = $input['name'];
                            $field['type']   = $input['type'];
                            $field['status']  = '1';
                            
    				        $current_user_id = User::create($field)->id;
    				        
    				        $user = User::where('id', $current_user_id)->first();
    				        
    				        $token = $user->createToken('MyApp')->accessToken;
    				        
    				        parent::addUserDeviceData($user, $request);
    				        return parent::success(['message' => 'login successfully', 'token' => $token,'user' => $user]);
                        }
    				  

    				} else {
    			        
                            $userId  = User::create($field)->id;
                            $user = User::where('id', $userId)->first();
                            $token = $user->createToken('MyApp')->accessToken;
                            parent::addUserDeviceData($user, $request);
                            return parent::success(['message' => 'login successfully','token' => $token, 'user' => $user]);
    				  
    				}
    				 
    			}
                

            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
    }

    
    

    public function Logout(Request $request) {
        $rules = [];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {

            if (Auth::check()) {
                Auth::user()->AauthAcessToken()->delete();
            }
            $device = \App\UserDevice::where('user_id', \Auth::id())->get();
//            dd($device);
            if ($device->isEmpty() === false)
                \App\UserDevice::destroy($device->first()->id);

            return parent::successCreated('Logout Successfully');
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function Signup(Request $request) {
        // |unique:users,mobile_no

        $rules = ['fname' => 'required', 'lname' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required',  'mobile_no' => 'required', 'phonecode' => 'required', 'type' => 'required|in:1,2'];
        $rules = array_merge($this->requiredParams, $rules);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            $errors = self::formatValidator($validator);
            // dd($errors);
            return parent::error($errors);
        }
        $input = $request->all();
//        if (isset($request->image))
//            $input['image'] = parent::__uploadImage($request->file('image'), public_path(\App\Http\Controllers\Admin\UsersController::$_mediaBasePath), true);
        $fullname = $input['fname'].' '.$input['lname'];
        $input['name'] = $fullname;
        $input['status'] = '1';
        $input['token'] = uniqid(md5(rand()));
        $input['password'] = bcrypt($input['password']);
        
        // Stripe Create user;
        
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->create([
            'description' => 'My First Test Customer (created for API docs)',
            'email' => $input['email'],
            'name'  => $fullname,
             ]);
        $input['custom_id'] = $customer->id;
        $user = User::create($input);
    
        parent::sendOTPUser($user);
        
        
        // dd($customer->id);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $userData  = User::select($this->LoginAttributes)->where('id', $user->id)->first();
        $success['user'] = $userData;
        
       
        
        $lastId = $user->id;
        $selectClientRole = [];
        if($user->type == 1):
            $selectClientRole = Role::where('name', 'Client')->first();
            else:
            $selectClientRole = Role::where('name', 'Artist')->first();
        endif;
        
        $assignRole = DB::table('role_user')->insert(
                ['user_id' => $lastId, 'role_id' => $selectClientRole->id]
        );

        // Add user device details for firbase
        parent::addUserDeviceData($user, $request);
    
        // if ($user->status != 1) {
        //     return parent::error('Please contact admin to activate your account', 200);
        // }
       
        return parent::success($success, $this->successStatus);
    }
    
    
    public function resendOTP(Request $request){
        // dd(Auth::id());
        $rules = ['phonecode' => '', 'mobile_no' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                $input = $request->all();
                $user = User::findOrFail(Auth::id());
                
                if(isset($input['mobile_no']) && isset($input['phonecode'])){
                    $user->phonecode = $input['phonecode'];
                    $user->mobile_no = $input['mobile_no'];
                    $user->save();
                    parent::sendOTPUser($user);
                }else{
                    
                    if(!empty($user->mobile_no)):
                    
                        // $user->phonecode = $input['phonecode'];
                        // $user->mobile_no = $input['mobile_no'];
                        // $user->save();
                        parent::sendOTPUser($user);
                    endif;    
                }
               
                
                $UserData = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
                return parent::success(['message' => 'OTP has been send successfully to your number!', 'user' => $UserData]);
            
                
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
   
   
    public function VerifyOTP(Request $request){
        $rules = ['otp' => 'required|numeric|digits:4'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                $input = $request->all();
                
                $otp = $input['otp'];
                $user = User::where('id', Auth::id())->where('otp', $otp)->first();
            
                if(is_null($user) === true):
                        return  parent::error($otp.' OTP does not match');
                    endif;
                
                    // $user = new User();
                    $user->status = '2';
                    $user->mobile_verified = '1';
                    $user->save();
                
                return parent::success(['message' => 'OTP verification successfuly!', 'user' => $user]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
        
    }
    
    
    public function EmailVerification(Request $request){
        $rules = ['otp' => 'required||numeric|digits:4','email' => 'required|exists:users,email'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $input = $request->all();
                $user = User::where('email', $input['email'])->where('email_otp', $input['otp'])->first();
            
                if(is_null($user) === true):
                    return response()->json(['status' => false,'code' => 422,'error' => 'OTP mismatched']);
                        // return  parent::error($input['otp'].' OTP does not match');
                    endif;
                
                return parent::success(['message' => 'Email verification successfully!']);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    public function EmailResetPassword(Request $request){
        $rules = ['email' => 'required', 'password' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $input = $request->all();
                $data['password'] = hash::make($input['password']);
                // dd($password);
                $user = \App\User::where('email', $input['email'])->update($data);
            
                return parent::success(['message' => 'Your password has been successfully changed!']);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    public  function CustomerCreateProfile(Request  $request){
        
      $rules = ['zipcode' => '', 'dob' => 'required', 'gender' => 'required', 'description'=>'', 'profile_picture'=> 'required','fname'=> 'required','lname'=>'required'];
      
      $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
      if($validateAttributes):
          return $validateAttributes;
          endif;

      try{
          
            $input = $request->all();
            $model = new User();
            $user = $model->select($this->LoginAttributes)->find(Auth::id());
          if($user != ''):
              
            if(!empty($request->file('profile_picture'))):
                $file = $request->file('profile_picture');
                $profile_picture =  self::imageUpload($file, 'uploads/client');
                $user['profile_picture'] = $profile_picture;
            endif;  
              
            $user['zipcode'] = ($input['zipcode'])? $input['zipcode']:'';
            $user['dob'] = $input['dob'];
            $user['gender'] = $input['gender'];
            $user['description'] = $input['description'];
            $user['fname'] = $input['fname'];
            $user['lname'] = $input['lname'];
            // $user['mobile_no'] = $input['mobile_no'];
            $user['status'] = '3';
            $user->save();
//            return parent::success(['message'=>'Profile created successfully', 'data'=> $user]);
            return parent::successCreated(['message' => 'Profile Created Successfully',  'user' => $user]);
        else:
                return parent::error('Invalid Auth Token');
          endif;
            
          
          
      }catch (\Exception $ex){
          return parent::error($ex->getMessage());
      }
      
    }
    
    
    
    public  function ArtistCreateProfile(Request  $request){
      
      $rules = ['zipcode' => '', 'experience' => 'required','license_no' => '','upload_id'=>'','profile_picture'=> 'required','fname' =>'required','lname'=>'required'];
      $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
      if($validateAttributes):
          return $validateAttributes;
          endif;
 
      try{
          
            $input = $request->all();
            $model = new User();
            $user = $model->select($this->LoginAttributes)->find(Auth::id());
          if($user != ''):
              
            if(!empty($request->file('profile_picture'))):
                $file = $request->file('profile_picture');
                $profile_picture =  self::imageUpload($file , 'uploads/artist');
                $user['profile_picture'] = $profile_picture;
            endif;
            
            if(!empty($request->file('upload_id'))):
                
                $file = $request->file('upload_id');
                $upload_id =  self::imageUpload($file , 'uploads/artist');
                $user['upload_id'] = $upload_id;
            endif;  
              
                $user['zipcode'] = ($input['zipcode'])?$input['zipcode']:'';
                $user['experience'] = $input['experience'];
                $user['license_no'] = $input['license_no'];
                $user['fname'] = $input['fname'];
                $user['lname'] = $input['lname'];
                // $user['mobile_no'] = $input['mobile_no'];
           
                $user['status'] = '3';
                $user->save();
//            return parent::success(['message'=>'Profile created successfully', 'data'=> $user]);
                return parent::successCreated(['message' => 'Profile Created Successfully',  'user' => $user]);
            else:
                return parent::error('Invalid Auth Token');
            endif;
            
      } catch (\Exception $ex){
          return parent::error($ex->getMessage());
      }
      
    }

    public function ArtistViewProfile(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $user = User::select($this->LoginAttributes)->with('user_post','user_avg_rating')->find(Auth::id());
            $Availability = \App\Availability::select('description')->where('user_id', Auth::id())->first();
          
            $user['description'] = $Availability['description'];
            return parent::success(['message'=> 'View profile successfully', 'user' => $user]);
            
        } catch (\Execption $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function changePassword(Request $request) {
        
        $rules = ['old_password' => 'required', 'password' => 'required', 'password_confirmation' => 'required|same:password'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        
        try {
            
            if (\Hash::check($request->old_password, \Auth::User()->password)):
                $model = \App\User::find(\Auth::id());
                $model->password = \Hash::make($request->password);
                $model->save();
                return parent::success(['message'=>'Password Changed Successfully']);
            else:
                return parent::error('Please use valid old password');
            endif;
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function SocialLink(Request $request){
      $rules = ['facebook' => '','instagram'=>''];
      $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
      if($validateAttributes):
          return $validateAttributes;
      endif;
      try{
          $data = [];
          $input = $request->all();
          $user_id = Auth::id();  
          $data = [
              'user_id' => $user_id,
              'facebook'   => $input['facebook'],
              'instagram'  => $input['instagram']
            
          ];
        
        $model = User::find($user_id);
        $update['status'] = '4';
        $model->fill($update);
        $model->save();
        
        $id = SocialLink::updateOrCreate(['user_id' => $user_id] ,$data)->id;
        // dd($id);
        $social = SocialLink::where('id', $id)->first();
        $artist = User::select($this->LoginAttributes)->where('id', $user_id)->first();
        return parent::success(['message' => 'Social Link Added!','social_link'=> $social, 'user' => $artist]);
     
      }catch( \Exception $ex ){
        return parent::error($ex->getMessage());
      }
    }

    public function ViewSocialLink(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $socialLinks = SocialLink::where('user_id', Auth::id())->first();
            return parent::success(['message' => 'View social links', 'social_links' => $socialLinks]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function EditSocialLink(Request $request){
      $rules = ['facebook' => '','instagram'=>''];
      $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
      if($validateAttributes):
          return $validateAttributes;
      endif;
      try{
          $data = [];
          $input = $request->all();
          
          $data = [
              'user_id' => Auth::id(),
              'facebook'   => $input['facebook'],
              'instagram'  => $input['instagram'],
              
          ];
        
          SocialLink::updateOrCreate(['user_id' => Auth::id()], $data);
        
       
          $social = SocialLink::where('user_id', Auth::id())->first();
        
        return parent::success(['message' => 'Social media links are updated successfully!','social_link'=> $social]);
     
      }catch( \Exception $ex ){
        return parent::error($ex->getMessage());
      }
    }
    
    
    public function Contactus(Request $request){
        $rules = ['name'=> 'required', 'email'=>'required','subject' => 'required','message' => ''];
        $validateAttributes = parent::ValidateAttributes($request,'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $model = App\ContactUs::Create($input);
            return parent::success(['message' => 'email has been sent successfully']);
        }catch(\Execption $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    

    public function getDirectories(Request $request) {
        $model = new App\Directory;
        if ($model->get()->isEmpty() === false) {
            $perPage = isset($request->limit) ? $request->limit : 20;
            if (isset($request->search))
                $model = $model->Where('name', 'LIKE', "%$request->search%");
            $model = $model->orderBy('id', 'desc');
            return parent::success($model->paginate($perPage));
//            return parent::success($directories, $this->successStatus);
        } else {
            return parent::error('No Directories Found', 200);
        }
    }

    public function getAlphaLinks(Request $request) {
        $model = new App\AlphaLink;
        if ($model->get()->isEmpty() === false) {
            $perPage = isset($request->limit) ? $request->limit : 20;
            if (isset($request->search))
                $model = $model->Where('name', 'LIKE', "%$request->search%");
            $model = $model->orderBy('id', 'desc');
            return parent::success($model->paginate($perPage));
        } else {
            return parent::error('No Alpha Links Found', 200);
        }
    }

    public function getMeta(Request $request) {

        $validator = Validator::make($request->all(), [
                    'meta_name' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = self::formatValidator($validator);
            return parent::error($errors, 200);
        }
        $meta = App\Meta::where('meta_name', $request->input('meta_name'))->first();
        if ($meta) {
            return parent::success($meta, $this->successStatus);
        } else {
            return parent::error('No Meta Content Found', 200);
        }
    }

    public function resetPassword(Request $request, Factory $view) {
        //Validating attributes
        $rules = ['email' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        $view->composer('emails.auth.password', function($view) {
            $view->with([
                'title' => trans('front/password.email-title'),
                'intro' => trans('front/password.email-intro'),
                'link' => trans('front/password.email-link'),
                'expire' => trans('front/password.email-expire'),
                'minutes' => trans('front/password.minutes'),
            ]);
        });
        return parent::success('Email has been send');
//        dd($request->only('email'));
        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject(trans('front/password.reset'));
                });
//        dd($response);
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return parent::successCreated('Password reset link sent please check inbox');
            case Password::INVALID_USER:
                return parent::error(trans($response));
            default :
                return parent::error(trans($response));
                break;
        }
        return parent::error('Something Went');
    }
    
    
    
    public function ForgotPassword(Request $request){
        $rules = ['email' => 'required|exists:users,email'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules,  array_keys($rules), true);
        if($validateAttributes):
           
            return $validateAttributes;
        endif;
        try{
           
                $input = $request->all();
                $User = \App\User::select('fname','lname', 'email')->where('email', $input['email'])->first();
               
                $OTP = rand(1000,9999);
                $data = [];
                $data['title'] = 'Hi @'.$User->fname.' '.$User->lname.'!';
                $data['message'] = 'Your Wamglamz verification code is '.$OTP.' This help us secure your wamglamz account by verifying your OTP. This let you to access your wamglamz account.';
                // dd($data);
                
                // send grid
                
                $email = new \SendGrid\Mail\Mail();
                    $email->setFrom(getenv('MAIL_ADDRESS'), "Wamglamz");
                    $email->setSubject("Forgot Password");
                    $email->addTo($input['email'], $User->fname.' '.$User->lname);
                    $email->addContent("text/plain", "Wamglamz forgot password");
                    $email->addContent(
                        "text/html", "<strong>".$data['message']."</strong>"
                    );
                $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
                 $response = $sendgrid->send($email);
                    // print $response->statusCode() . "\n";
                    // print_r($response->headers());
                    // print $response->body() . "\n";
                // send-end
                
                
                
                
                
                $mail = Mail::to("99yogesh.sharma@gmail.com")->send( new ForgotPassword($data));
                // $mail = Mail::to($input['email'])->send( new ForgotPassword($data));
                // dd(count(Mail::failures()));
                \App\User::where('email', $User->email)->update(['email_otp' => $OTP]);                
               
                return parent::success(['message' => 'The email has been successfully']);
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function getRegisterdUserDetails(Request $request) {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'GET', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {
//            dd(\Auth::id());
            $model = \App\User::whereId(\Auth::id());
            return parent::success($model->first());
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function Payment( Request $request ){
        
        $rules = ['name'=>'required','card_no'=>'required','zipcode'=>'', 'expiry_month'=>'required', 'expiry_date'=>'required', 'cvv'=>'required', 'payment_status' => 'required'];
        
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            
            $user = User::select($this->LoginAttributes)->where('id',Auth::id())->first();
            
            $input =  $request->all();
        
          
                $input['status'] = '1';
       
            
                $input['card_no'] = $input['card_no'];
                $input['cvv'] = base64_encode($input['cvv']);
                $input['user_id'] = Auth::id();
                
                $data = [
                    'name' => Auth::user()->fname.' '. Auth::user()->lname,
                    'email' => Auth::user()->email,
                    'description' => 'create Customer'
                    ];
                
                  Helper::CreateCustomer($data);
                
                
                $payment = Payment::Create($input);
            
            if($input['payment_status'] == 1):
          
                if($user->type == '1'):
                    $Updateuser = User::where('id',Auth::id())->update(['status' => '4']);    
                elseif($user->type == '2'):
             
                    $Updateuser = User::where('id',Auth::id())->update(['status' => '8']);    
                endif;
                
                $userDetails = User::select($this->LoginAttributes)->where('id',Auth::id())->first();
                
                $paymentDetail = payment::where('id',$payment->id)->first();
                
                return parent::success(['message' => 'Payment Added successfully!', 'user' => $userDetails, 'payment'=> $payment]);
                
            endif;
            
            return parent::success(['message' => 'Payment Added successfully!', 'user' => $user, 'payment'=> $payment]);
            
            
        } catch (\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    public function Favourite(Request $request){
        $rules = ['status' => 'required|in:1,2', 'artist_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
                 
        try{
            
            $input = $request->all();
       
                    $data = [
                        'like_by' => Auth::id(),
                        'like_to' => $input['artist_id'],
                        'status'  => $input['status']
                        ];
                  
                    $favourite = App\Favourite::updateOrCreate(['like_to' => $input['artist_id']], $data);
                    $message = ($favourite['status'] == '1')? 'Like successfuly': 'Dislike successfully';
        
                return parent::success(['message' => $message]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    public function FavouriteList(Request $request){
   
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            // DB::enableQueryLog();
            $favourites = App\Favourite::where('like_by', Auth::id())->where('status', '1')->with('artist_details')->get();
         
            
            // dd(DB::getQueryLog());
            return parent::success(['message' => 'view favourite list successfully', 'favourites' => $favourites]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function FavouriteListById(Request $request){
        $rules = ['id'=> 'required'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        
        try{
            $input = $request->all();
            $favourite = App\Favourite::where('id', $input['id'])->with('artist_details')->first();
            
            return parent::success(['message' => 'View favourite list successfully', 'favourite' => $favourite]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    
    
    public function UserChat(Request $request){
        $rules = ['reciever_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
        try{
            
            
            // mycode
            $input = $request->all();
            $reciever_id = $input['reciever_id'];
            $user_id = Auth::id();
          
        if(!empty($user_id) && $reciever_id!=''){
                // $userId = $tokenDecode->id;
          
          
        //   mycode
        $sql = "SELECT DISTINCT sender.fname as senderName, sender.id as sender_id, sender.profile_picture as sender_profile_picture,receiver.fname as receiverName, receiver.id as receiver_id, receiver.profile_picture as receiver_profile_picture,msg.message,msg.created_on,msg.status as readStatus,msg.MessageType,IF((select COUNT(*) from chat_deleteTB where deleteByuserID='".$user_id."' AND ChatParticipantID='".$reciever_id."'>0),1,0) as chatDelRow FROM user_chat msg INNER JOIN users sender ON msg.source_user_id = sender.id
        INNER JOIN users receiver ON msg.target_user_id = receiver.id WHERE ((msg.source_user_id='".$user_id."' AND msg.target_user_id='".$reciever_id."') OR 
        (msg.source_user_id='".$reciever_id."' AND msg.target_user_id='".$user_id."')) HAVING IF(chatDelRow=1,(msg.created_on>(select deletedDate from chat_deleteTB where deleteByuserID='".$user_id."' AND ChatParticipantID='".$reciever_id."')),'1999-01-01 05:06:23') ORDER BY msg.created_on ASC";
        
      
        
        // mycodeEnds
                // DB::enableQuerylog();
                $RecentChat = DB::select($sql);
                // dd(DB::getQueryLog());
                $checkBlock = DB::select("SELECT * FROM `block_users` WHERE ((block_id='".$user_id."' AND block_by_id='".$reciever_id."') OR (block_id='".$reciever_id."' AND block_by_id='".$user_id."')) AND status='2'");
               
                if($checkBlock)
                {
                    $blockStatus=1;
                    $block_by_id=$checkBlock['block_by_id'];
                }
                else
                {
                    $blockStatus=0; 
                    $block_by_id=0;
                }
            
                if(!empty($RecentChat)) {
                    return $response=array("status"=>true,"code"=>200,"message"=>"View Messages successfully!","data" =>$RecentChat,"blockStatus" => $blockStatus,"BlockByID" =>$block_by_id);  
                // return parent::success(['message' => 'View Messages successfully!','data' => $RecentChat,"blockStatus" => $blockStatus,"BlockByID" =>$block_by_id]);
                }else {
                    return $response=array("status"=>true,'data'=> [], "message"=>"Data not found");  
                    
                }
            }else{
                $response=array("status"=>false,"message"=>"empty token"); 
                // return parent::error('empty Token');
            }
           
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }
    
    
    public function Blogs(Request $request){
        
        // dd(asset('uploads/admin/blogs'));
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
            endif;
                
                try{
                    
                    
                    $blogs = App\Blog::get();
                    return parent::success(['message' => 'View blogs successfully!','blogs' => $blogs]);
                }catch(\Exception $ex){
                    return parent::error($ex->getMessage());
                }
    }
    
    
    public function BlogDetailsById(Request $request){
        $rules = ['id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $input = $request->all();
                $blog = App\Blog::where('id', $input['id'])->first();
                return parent::success(['message' => 'View Blog Successfully!','blog' => $blog]);
            }catch(\Excpetion $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    public function PlanDetails(Request $request){
      
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                
                $plan_details = \App\PlanDetail::get();
                
                return parent::success(['message' => 'Plan view successfully!', 'plan_details'=> $plan_details]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
         
    }
    
    
    public function PlanDetailsById(Request $request){
        $rules = ['id'=> 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        
        if($validateAttributes):
            return $validateAttributes;
            endif;
            
            try{
                
                $input  = $request->all();
               
                if(Auth::user()->type == '1'):
                    $user = User::where('id',Auth::id())->update(['status' => '4']);    
                elseif(Auth::user()->type == '2'):
                        $user = User::where('id',Auth::id())->update(['status' => '8']);
                endif;
                 $plan_details = \App\PlanDetail::where('id', $request->id)->first();
                return parent::success(['message' => 'View Plan Successfully!', 'plan_details'=> $plan_details]);
            }catch(\Exception  $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    
    
     public function viewNotification(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, "POST", $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
              
                $notification = Notification::where('receiver_id', Auth::id())->orderBy('id','DESC')->get();
              
                return parent::success(['message' => 'Notification view successfully!', 'notification' => $notification]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    public function FAQ(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $faq = DB::table('faq')->get();
                return parent::success(['message' => 'FAQ view successfully!', 'faq' => $faq]);
            }catch(\Exception $ex){
                return parent::error($ex->getMessage());
            }
    }
    
    
    public function GetSubscription(request $request){
        $rules = ['plan_id' => 'required', 'amount' => '', 'type' => 'required','plan_type' => '', 'duration' => ''];
        // plan type---> 1-> $25, 2 $50
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
            endif;
            try{
                $input = $request->all();
                $input['user_id'] = Auth::id();
                $input['created_on'] = date('Y-m-d');
                if($input['type'] == '1'):
                    dd('hello');
                elseif($input['type'] == '2'):
                    
                    $input['product_id'] = env("ARTIST_PRODUCT_ID");
                    
                    if($input['plan_type'] == '1'):
                        $input['price_id']  = env("ARTIST_PRODUCT_PRICE_1");
                        elseif($input['plan_type'] == '2'):
                            $input['price_id']  = env("ARTIST_PRODUCT_PRICE_2");
                            endif;
                     
                endif;
                $data = [
                    'email' => Auth::user()->email,
                    'name'  => Auth::user()->fname.' '. Auth::user()->lname,
                    'description' => 'Subscription plan'
                    ];
                 
                  Helper::CreateCustomer($data);
                $subscription  = Subscription::create($input);
                
                return parent::success(['message' => 'Subscription Buy Successfully']);
            }catch(\Exception $ex){
                return parent::error($ex->getmessage());
            }
    }

   


}
