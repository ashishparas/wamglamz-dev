<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Role;
use App\User;
use App\Booking;
use App\ContactUs;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
      
        $user = User::get()->count();
        $artist = User::where('type', '2')->get()->count();
        $booking = Booking::get()->count();
        return view('home', compact('user', 'artist','booking'));
    }
    
    
    
    public function host(){
        return view('welcome');
    }
    
    
    public function contact_us(Request $request){
        $input = $request->all();
        
        ContactUs::create($input);
        return Redirect('/')->with(['msg' => 'form has been submitted!']);
        
        
    }
    
    public function ArtistCancellationPolicy(){
        // echo  'hello there';
        return view('artist-cancellation-policy');
    }
    public function cancellationPolicy(){
        // echo  'hello there';
        return view('cancellation-policy');
    }
    
    public function PrivacyPolicy(){
        return view('privacy-policy');
    }
    
    public function RefundPolicy(){
        return view('refund-policy');
    }
    
    public function About(){
        return view('about-us');
    }

}
