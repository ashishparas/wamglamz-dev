<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Customer API's

// Artist API's
//Route::post('artist/signup', 'API\AuthController@ArtistSignup'); 
Route::post('signup', 'API\AuthController@Signup'); 
Route::post('login', 'API\AuthController@login');
//Route::post('artist/login', 'API\AuthController@ArtistLogin');
Route::post('customer/existence', 'API\AuthController@AuthCheck');
Route::post('service-provider/login', 'API\AuthController@Artistlogin'); 
Route::post('faq', 'API\AuthController@FAQ');
Route::post('reminder', 'API\ArtistController@CheckAppointments');
Route::post('customer/forget-password', 'API\AuthController@resetPassword');
Route::post('service-provider/forget-password', 'API\AuthController@resetPassword');
Route::post('text/message', 'API\ArtistController@TaxtMessage'); 
Route::get('customerPrivacy/{column}', 'API\ConfigurationController@getPrivacyPolicyColumn');
Route::post('payload', 'API\ClientController@payload');
Route::post('generate/otp', 'API\AuthController@GenterateOTP');
Route::post('email/verification', 'API\AuthController@EmailVerification'); 
Route::post('email/reset/password', 'API\AuthController@EmailResetPassword');





Route::group(['middleware' => ['auth:api', 'roles'], 'namespace' => 'API'], function() {

     //    Client APP
    Route::post('contact_us', 'AuthController@Contactus'); 
    Route::post('user/chat', 'AuthController@UserChat'); 
    Route::post('get/subscription', 'AuthController@GetSubscription');
    
    Route::post('customer/create_profile', 'AuthController@CustomerCreateProfile');  
    Route::post('blogs', 'AuthController@Blogs');  
    Route::post('blogs/by/id', 'AuthController@BlogDetailsById');  
    Route::post('plan/details', 'AuthController@PlanDetails');
    Route::post('plan/details/by/id', 'AuthController@PlanDetailsById');
    
    Route::post('add/payment', 'AuthController@Payment'); 
    Route::post('favourite', 'AuthController@Favourite'); 
    Route::post('favourite/list', 'AuthController@FavouriteList'); 
    Route::post('favourite/list/by/id', 'AuthController@FavouriteListById');
    Route::post('customer/home', 'ClientController@CustomerHome'); 
    Route::post('customer/view/sub_categories', 'ClientController@ViewSubCategories'); 
    Route::post('view/artist/service/profile', 'ClientController@ViewArtistServiceProfile'); 
    Route::post('view/customer/profile', 'ClientController@ViewProfile'); 
    Route::post('edit/customer/profile', 'ClientController@UpdateProfile'); 
    Route::post('edit/artist/profile', 'ArtistController@UpdateProfile');
    Route::post('view/customer/cards', 'ClientController@ViewPaymentCards'); 
    Route::post('view/ratings', 'ClientController@ViewRatings'); 
    Route::post('delete/customer/card', 'ClientController@DeletePaymentCard'); 
    Route::post('plans', 'ClientController@Plans'); 
    Route::post('artist/ratings', 'ClientController@Ratings'); 
    Route::post('appointments', 'ClientController@Appointment'); 
    Route::post('client/booking/status', 'ClientController@ClientBookingStatus'); 
    Route::post('check/schedule/appointment', 'ClientController@CheckScheduleAppointment');
    
//    Artist
    Route::post('artist/create/profile', 'AuthController@ArtistCreateProfile'); 
    Route::post('view/artist/profile', 'AuthController@ArtistViewProfile'); 
    Route::post('social_links', 'AuthController@SocialLink'); 
    Route::post('availabilities', 'ArtistController@Availability'); 
    Route::post('schedule', 'ArtistController@Schedule'); 
    Route::post('edit/schedule', 'ArtistController@EditSchedule'); 
    Route::post('confirm/schedule', 'ArtistController@ConfirmSchedule'); 
    Route::post('edit/artist/services', 'ArtistController@EditServices');  
    Route::post('services', 'ArtistController@Services');
    Route::post('men/services', 'ArtistController@MenServices');    
    Route::post('set/default/card', 'ArtistController@SetDefaultPayment');
    
    
    Route::post('add/services', 'ArtistController@AddServices'); 
    Route::post('add/women/services', 'ArtistController@WomenServices'); 
    Route::post('add/men_services', 'ArtistController@AddMenServices'); 
    Route::post('get_selected/services', 'ArtistController@GetArtistSelectedServices'); 
    Route::post('add_all/services', 'ArtistController@AllServices'); 
    Route::post('add/artist/payment', 'ArtistController@Payment'); 
    Route::post('customer/ratings', 'ArtistController@Ratings'); 
    Route::post('artist/plan', 'ArtistController@ArtistPlan'); 
    Route::post('view/availability', 'ArtistController@ViewAvailability'); 
    Route::post('edit/availability', 'ArtistController@EditAvailability');
    Route::post('view/social/link', 'AuthController@ViewSocialLink'); 
    Route::post('edit/social/link', 'AuthController@EditSocialLink'); 
    Route::post('contact_us', 'AuthController@Contactus');
    Route::post('posts', 'ArtistController@Posts');  
    Route::post('view/posts', 'ArtistController@ViewPosts');
    Route::post('posts/by/id', 'ArtistController@PostById'); 
    Route::post('delete/post', 'ArtistController@DeletePost'); 
    Route::post('view/artist/schedule', 'ArtistController@ViewSchedule');  
    Route::post('delete/artist/schedule', 'ArtistController@DeleteSchedule');  
    Route::post('artist/details/by_id', 'ArtistController@ArtistDetailsById'); 
    Route::post('booking', 'ArtistController@Booking'); 
    Route::post('services/by/artist', 'ArtistController@ServicesByArtist');
    Route::post('artist/all/services', 'ArtistController@ArtistAllServices'); 
    Route::post('artist/appointments', 'ArtistController@ArtistAppointments');
    Route::post('view/booking/byId', 'ArtistController@ViewBookingById'); 
    Route::post('client/view/booking/byId', 'ArtistController@ClientViewBookingById');
    Route::post('appointment/request', 'ArtistController@AppointmentRequest'); 
    Route::post('schedule/appoinments', 'ArtistController@ScheduleAppontments'); 
    Route::post('/cancel/request', 'ArtistController@CancelRequest'); 
    Route::post('view/notification', 'AuthController@viewNotification'); 
    Route::post('otp/verification', 'AuthController@VerifyOTP'); 
    Route::post('resend/otp', 'AuthController@resendOTP'); 
    
    
});
    Route::post('forgot/password', 'API\AuthController@ForgotPassword');  
    Route::post('social/login', 'API\AuthController@Social_login');
    
    Route::group(['middleware' => 'auth:api'], function() {
    
    

    Route::post('logout', 'API\AuthController@Logout');

    Route::get('customer/profile', 'API\AuthController@CustomerProfile');
    
    Route::post('service_provider/edit', 'API\AuthController@ServiceProviderProfileEdit');
    Route::post('customer/edit-profile', 'API\AuthController@ProfileUpdate');
    Route::get('service-provider/logout', 'API\AuthController@logout');
    Route::get('service-provider/profile', 'API\AuthController@CustomerProfile');
    Route::post('change-password', 'API\AuthController@changePassword');
    // Route::post('artist/change-password', 'API\AuthController@changePassword');    
   
    
    Route::get('configuration/{column}', 'API\ConfigurationController@getConfigurationColumn');
    
    Route::post('ratings','API\RatingsController@ratings');
    Route::post('get/ratings','API\RatingsController@getRating');
    Route::post('notification', 'API\NotificationController@getItems');
    Route::post('messages', 'API\MessagesController@message'); 
    Route::post('get/message', 'API\MessagesController@getMessage');
    Route::post('message/list', 'API\MessageController@getItems');
    Route::post('message', 'API\MessageController@getItem');
});
