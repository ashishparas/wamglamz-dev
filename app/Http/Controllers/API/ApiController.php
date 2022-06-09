<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use App\UserDevice;
//fcm
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use DB;

class ApiController extends \App\Http\Controllers\Controller {

    /**
     * Create admin controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
//        $roles = implode('|', Role::all()->pluck('name')->toArray());
//        $this->middleware(['role:' . $roles, 'auth:admin']);
//        dd($roles);
    }

    private function _headers() {
        return getallheaders();
    }

    protected function __allowedUsers() {
        $userRole = \App\User::find($this->_headers()['user_id'])->getRoleNames()['0'];
        return \App\User::role($userRole)->get()->pluck('id')->toArray();
    }

    public $successStatus = 200;
    public static $locale = '';
//    public $requiredParams = ['device_id' => 'required', 'device_token' => 'required', 'device_type' => 'in:ios,android|required', 'client_id' => 'required', 'client_secret' => 'required'];
//    public $requiredParams = ['device_id' => 'required', 'device_type' => 'in:ios,android|required', 'client_id' => 'required', 'client_secret' => 'required'];
    public $requiredParams = ['device_type' => 'required|in:ios,android', 'device_token' => 'required'];
    protected static $_allowedURIwithoutAuth = ['api/login', 'api/customer/login', 'api/configuration/{type}', 'api/customer/verify-login', 'api/customer/registeration', 'api/customer/resend-otp', 'api/salon/register', 'api/salon/{id}', 'api/customer/register', 'api/customer/{id}'];

    public static function validateClientSecret() {
        $headers = getallheaders();
        if (!isset($headers['client_id']) || !isset($headers['client_secret'])):
            return self::error('Client Id and Secret not found.', 422);
        endif;
        $response = self::validateClient($headers['client_id'], $headers['client_secret']);
        if ($response === false) :
            return self::error('Client Id and Secret mismatched.', 409);
        endif;
//        dd(\Request::route()->uri());
        if (!in_array(\Request::route()->uri(), self::$_allowedURIwithoutAuth)):
            if (!isset($headers['user_id'])):
                return self::error('Loged in User Id is required', 422);
            else:
                $user = User::find($headers['user_id']);
                if ($user === null)
                    return self::error('Loged in User Not found', 401);
//                dd($user->hasAnyRole('super admin'));
                if ($user->hasPermissionTo(\Request::route()->uri()) === false):
                    return self::error("You're not authorized to do, Please contact administrator", 403);
                endif;
            endif;
        endif;
        if (isset($headers['locale'])):
            if (!in_array($headers['locale'], ['', 'kr', 'ar'])):
                return self::error('Please use valid language.', 422);
            endif;
            self::$locale = $headers['locale'];
        endif;
        return false;
    }

    protected static function validateClient($client_id, $client_secret) {
        $check = \App\Models\OauthClients::where(["id" => $client_id, "secret" => $client_secret]);
        if ($check->exists())
            return true;
        else
            return false;
    }

    protected static function validateHeadersOnly($request, $formType = 'GET', $attributeValidate = []) {
        $headers = getallheaders();
        if ($request->method() != $formType) {
            return self::error('This method is not allowed.', 409);
        }
        if (isset($headers['client_id']) && isset($headers['client_secret'])):
            $params['client_id'] = $headers['client_id'];
            $params['client_secret'] = $headers['client_secret'];
        endif;
//        if (isset($headers['device_id']) && isset($headers['device_token']) && isset($headers['device_type'])):
        if (isset($headers['device_id']) && isset($headers['device_type'])):
            $params['device_id'] = $headers['device_id'];
//            $params['device_token'] = $headers['device_token'];
            $params['device_type'] = $headers['device_type'];
        endif;
        $validator = Validator::make($params, $attributeValidate);
        if ($validator->fails()) {
            $errors = [];
            $messages = $validator->getMessageBag();
            foreach ($messages->keys() as $key) {
                $errors[] = $messages->get($key)['0'];
            }
            return self::error($errors, 422, false);
        }
        return false;
    }

    public static function validateAttributes($request, $formType = 'GET', $attributeValidate = [], $attributes = [], $checkVariableCount = true) {

        $headers = getallheaders();

        if ($request->method() != $formType) {
            return self::error('This method is not allowed.', 409);
        }
        $params = [];
        if (isset($headers['client_id']) && isset($headers['client_secret'])):
            $params['client_id'] = $headers['client_id'];
            $params['client_secret'] = $headers['client_secret'];
        endif;
//        if (isset($headers['device_id']) && isset($headers['device_token']) && isset($headers['device_type'])):
//        if (isset($headers['device_id']) && isset($headers['device_type'])):
//            $params['device_id'] = $headers['device_id'];
////            $params['device_token'] = $headers['device_token'];
//            $params['device_type'] = $headers['device_type'];
//        endif;
       
        foreach ($attributes as $attribute):
            $params[$attribute] = $request->$attribute;
        endforeach;
       
        if ($checkVariableCount === true):
            if (count($attributes) != count($request->all())):
                return self::error('Please fill required parameters only.', 409);
            endif;
//        else:
//            if (count($request->all()) == 0):
//                return self::error('Please select one of the paramter.', 409);
//            endif;
        endif;
//        dd($params);
        $validator = Validator::make($params, $attributeValidate);
        if ($validator->fails()) {
            $errors = [];
            $messages = $validator->getMessageBag();
            foreach ($messages->keys() as $key) {

                $errors = $messages->get($key)['0'];
            }
            return self::error($errors, 422, false);
        }
        return false;
    }

    public static function error($message, $errorCode = 422, $messageIndex = false) {

        return response()->json(['status' => false, 'code' => $errorCode, 'data' => (object) [], 'error' => $message], $errorCode);
    }

    public static function success($data, $code = 200, $returnType = 'object') {
        // print_r($returnType);die;
        if ($returnType == 'data')
            $data = $data;
        elseif ($returnType == 'array')
            $data = (array) $data;
        else
            $data = $data;
        return response()->json(['status' => true, 'code' => $code, 'data' => $data], $code);
    }

    public static function successCreated($data, $code = 201) {
        if (!is_array($data))
            $data = ['message' => $data];
        return response()->json(['status' => true, 'code' => $code, 'data' => (object) $data], $code);
    }

    protected static function sendOTPUser(User $user) {
    // dd($user);
        $otp = mt_rand(1000, 9999);
        $user->otp = $otp;
        $user->save();
    $phonecode =     str_replace('+','', trim($user->phonecode));
    $phonecode = '+'.$phonecode;
  
        return self::sendTextMessage('<#> Your ' . config('app.name') . ' OTP is ' . $otp.' Use this to verify your mobile '. config('app.name') ,$phonecode,$user->mobile_no);
    
        // dd('otp');
    }

    protected static function sendOTP($number) {
        $otp = mt_rand(1000, 9999);
        return self::sendTextMessage('Your ' . config('app.name') . ' Verification code is ' . $otp, $number);
        return $otp;
    }

    protected static function sendTextMessage($message, $phonecode="+91" ,$to = '9068768054') {
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
           
            $twilio = new Client($sid, $token);
      
            //$return = $twilio->messages->create("" . $to, ["body" => $message, "from" => env('TWILIO_FROM')]);
       
            $phonecode =     str_replace('+','', trim($phonecode));
            $phonecode = '+'.$phonecode;
          
            $return = $twilio->messages->create($phonecode . $to, ["body" => $message, "from" => env('TWILIO_FROM')]);
            // dd($return);
            return $return;
        } catch (\Twilio\Exceptions\TwilioException $ex) {
            // dd(self::error($ex->getMessage()));
            return true;
        }
    }
    
    
    // twilio otp verification code start
    
        /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */


    // twilio otp verification code end
    
    
    
    

    public static function pushNotofication($data = [], $deviceToken) {
     
     
        $DeviceType = UserDevice::where('user_id', $data['to'])->first();
        
     
        if($DeviceType['type'] == 'android'):
            unset($data['payload']['notification']);
        elseif($DeviceType['type'] == 'ios'):
                unset($data['payload']['data']);
        endif;
              
        $optionBuilder = new OptionsBuilder();
        // $optionBuilder->setTimeToLive(60 * 20);
        $notificationBuilder = new PayloadNotificationBuilder($data['title']);
        $notificationBuilder->setBody($data['body'])->setSound('default');
      
        $dataBuilder = new PayloadDataBuilder();
        
        // $dataBuilder->addData(['to' => $data['to']]);
            $data['priority'] = 'high';
            $data['content_available'] = true;
            
        if( $DeviceType->type== 'android'): //
                $dataBuilder->addData($data);
                $dataBuilder->addData($data['payload']['data']); 
              
                // $dataBuilder->addData($data['payload']);
        elseif($DeviceType->type == 'ios'):
            $dataBuilder->addData($data);
                // $dataBuilder->addData(['notification' => $data['payload']['notification']]);
                
        endif;
        
        $option = $optionBuilder->build();
      
        $notification = $notificationBuilder->build();
      
        $data = $dataBuilder->build();
        
        // $deviceToken = "cd68yAvp4kimo2nwzxI2rc:APA91bF5txT99DFHCKrr5VxZWp5WQetE3ULVE2zgT-bPLkaUKyN_Z1uREQBrqvHlGNx6MLkbLs59bqOsrkNcYqJIQ8KUfnaCyvFFruwbzbyQQnr6PrcfIbJtOXtFVVftn76r01KyHjk4";

        $downstreamResponse = FCM::sendTo($deviceToken, $option, $notification, $data);
//        $downstreamResponse->numberFailure();
        return $downstreamResponse->numberSuccess() == '1' ? true : false;
    }

//    public function pushNotificationiOS($data, $devicetokens, $customData = null) {
//        foreach ($devicetokens as $devicetoken):
//            self::pushNotifyiOS($data, $devicetoken, $customData);
//        endforeach;
//        return true;
//    }

    public static function pushNotificationiOSMultipleUsers($data = [], $userIds, $customData = null) {
        foreach ($userIds as $userId):
            self::pushNotificationiOS($data, $userId, $customData);
        endforeach;
        return true;
    }

    public static function pushNotificationiOS($data = [], $userId, $customData = null) {
        foreach (\App\UserDevice::whereUserId($userId)->get() as $userDevice):
            self::pushNotifyiOS($data, $userDevice->token);
        endforeach;
        return true;
    }


    public static function pushNotifications($data = [], $userId, $receiver_id ,$saveNotification = true) {
   ;
        if ($saveNotification) {
          
            self::savePushNotification($data, $userId, $receiver_id);
        }

//        echo $userId;
//        dd(User::whereId($userId)->where('is_notify', '1')->get()->isEmpty());
//        
        //  if (User::whereId($userId)->where('is_login', '1')->get()->isEmpty() === true)
        //   return true;
        // if (User::whereId($userId)->where('is_notify', '1')->get()->isEmpty() === true)
        //   return true;
       
        foreach (\App\UserDevice::whereUserId($receiver_id)->get() as $userDevice):
              if(!empty($userDevice)):
                    self::pushNotofication($data, $userDevice->token);      
                  endif;
            
      
        endforeach;
        return true;
    }

    private static function savePushNotification($data, $userId, $receiver_id) {
      
        try {

            if (isset($data['payload']))
            
                $DeviceType = UserDevice::where('user_id', $data['to'])->first();
                
                if($DeviceType['type'] == 'android'):
                        unset($data['payload']['notification']);
                elseif($DeviceType['type'] == 'ios'):
                        unset($data['payload']['data']);
                endif;
            
            
            
                $data['data'] = json_encode($data['payload']);
                $data['created_by']  = $userId;
                $data['receiver_id']  = $receiver_id;
            // $data += ['action_id' => $receiver_id];
       
            \App\Notification::create($data);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    private static function pushNotifyiOS($data, $devicetoken, $customData = null) {
        //return true;
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', public_path('apn/key.pem'));
        stream_context_set_option($ctx, 'ssl', 'passphrase', '');
        // Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = ['alert' => ['title' => $data['title'], 'body' => $data['body']], 'sound' => 'default'];
        if ($customData !== null)
            $body['extraPayLoad'] = ['custom' => $customData];
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
//        pack("H*", "2133")
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        // $this->saveNotification($data);
        fclose($fp);

        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;
        //die();
    }
    
    
    
    public static function getNearBy($lat, $lng, $distance,$distanceIn = 'miles')
        {
            if ($distanceIn == 'km') {
                $results = User::select(['*', DB::raw('( 0.621371 * 3959 * acos( cos( radians('.$lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians(latitude) ) ) ) AS distance')])->havingRaw('distance < '.$distance)->get();
            } else {
                $results = User::select(['*', DB::raw('( 3959 * acos( cos( radians('.$lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians(latitude) ) ) ) AS distance')])->havingRaw('distance < '.$distance)->get();
            }
            return $results;
        }
    
    
    

    protected static function __uploadImageBase64($baseEncodeImage, $path = null) {
        $image = $baseEncodeImage;  // your base64 encoded
        $fileExtension = 'png';
        if (strpos($image, 'png') !== false):
            $image = str_replace('data:image/png;base64,', '', $image);
            $fileExtension = 'png';
        endif;
        if (strpos($image, 'jpeg') !== false):
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $fileExtension = 'jpeg';
        endif;
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10) . '.' . $fileExtension;
        if ($path === null)
            $path = public_path('uploads');
        \File::put($path . '/' . $imageName, base64_decode($image));
        return $imageName;
    }

    protected static function __uploadImage($image, $path = null, $thumbnail = false) {
        if ($path === null)
            $path = public_path('uploads');
        $digits = 3;
        $imageName = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1) . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);
//               ***************generate Thumbnail image start ********************* *
        if ($thumbnail === true):
            $path .= '/';
            $img = \Intervention\Image\ImageManagerStatic::make($path . $imageName)->resize(320, 240);
            $img->save($path . 'thumbnail_' . $imageName);
        endif;
//        /          ***************generate Thumbnail image end ********************* */
        return $imageName;
    }

    public static function getDistanceByTable($lat, $lng, $distance, $tableName) {
        $latKey = 'latitude';
        $lngKey = 'longitude';
        $results = \DB::select(\DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( ' . $latKey . ' ) ) * cos( radians( ' . $lngKey . ' ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(' . $latKey . ') ) ) ) AS distance FROM ' . $tableName . ' HAVING distance < ' . $distance . ' ORDER BY distance'));
//        dd($results);
        return $results;
    }

    protected static function CURL_API($method, $url, $data, $httpHeaders = []) {
        $curl = curl_init();
//        dd($data);
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        $headers = array_merge(['Content-Type: application/json'], $httpHeaders);
// OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//dd($data);
//dd($headers);
// EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return json_decode($result);
    }

    protected function getTokenQuickBlox() {
        // Application credentials - change to yours (found in QB Dashboard)
        DEFINE('APPLICATION_ID', 77979);
        DEFINE('AUTH_KEY', "xtvZ6Y3P7Sp4Z-Y");
        DEFINE('AUTH_SECRET', "N6KyLPtvWUqAyCn");
        // User credentials
        DEFINE('USER_LOGIN', "emma");
        DEFINE('USER_PASSWORD', "emma");
        // Quickblox endpoints
        DEFINE('QB_API_ENDPOINT', "https://api.quickblox.com");
        DEFINE('QB_PATH_SESSION', "session.json");
        // Generate signature
        $nonce = rand();
        $timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
        $signature_string = "application_id=" . APPLICATION_ID . "&auth_key=" . AUTH_KEY . "&nonce=" . $nonce . "&timestamp=" . $timestamp;
//        echo "stringForSignature: " . $signature_string . "<br><br>";
        $signature = hash_hmac('sha1', $signature_string, AUTH_SECRET);
        // Build post body
        $post_body = http_build_query(array(
            'application_id' => APPLICATION_ID,
            'auth_key' => AUTH_KEY,
            'timestamp' => $timestamp,
            'nonce' => $nonce,
            'signature' => $signature
        ));
        // $post_body = "application_id=" . APPLICATION_ID . "&auth_key=" . AUTH_KEY . "&timestamp=" . $timestamp . "&nonce=" . $nonce . "&signature=" . $signature . "&user[login]=" . USER_LOGIN . "&user[password]=" . USER_PASSWORD;
//        echo "postBody: " . $post_body . "<br><br>";
// Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION); // Full path is - https://api.quickblox.com/session.json
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POSTREDIR, true);

        // Execute request and read response
        $response = curl_exec($curl);

        // Check errors
        if ($response) {
            
        } else {
            $error = curl_error($curl) . '(' . curl_errno($curl) . ')';
            echo $error . "\n";
        }

        // Close connection
        curl_close($curl);
        return json_decode($response);
    }

    protected function registerUserQuickBlox($email, $name = null) {
        $response = self::getTokenQuickBlox();
        $data = self::CURL_API('POST', 'https://api.quickblox.com/users.json', ['user' => ['login' => $email, 'password' => $email, 'email' => $email, 'full_name' => $name]], ['QuickBlox-REST-API-Version: 0.1.0', 'QB-Token: ' . $response->session->token]);
//        dd($data->user->id);

        return $data;
    }

    protected function addUserDeviceData(User $user, $request) {
      
        // if (\App\UserDevice::where('token', $request->device_token)->get()->isEmpty() === true):
            
            // $userDevice = new \App\UserDevice;
            // $userDevice->user_id = $user->id;
            // $userDevice->type = $request->device_type;
            // $userDevice->token = $request->device_token;
            // $userDevice->save();
            \App\UserDevice::updateOrCreate(['user_id'=> $user->id],['user_id' => $user->id,'type' =>  $request->device_type, 'token' =>  $request->device_token]);
            
        // endif;
        return true;
    }
    
    

    public function formatValidator($validator) {

        $messages = $validator->getMessageBag();
        foreach ($messages->keys() as $key) {
            $errors[] = $messages->get($key)['0'];
        }
        return $errors[0];
    }

}
