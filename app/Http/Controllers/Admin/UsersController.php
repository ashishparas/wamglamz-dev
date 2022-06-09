<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use App\User;
use App\ContactUs;

class UsersController extends Controller {

    public function user(){
    	$users = DB::select('select id,name,mobile_no,email,created_at from users');
        return view('admin.users.user-management')->with('data',$users);
    }
    public function user_detail(Request $request){
    	$detail = DB::select("SELECT * FROM `users` WHERE id='$request->id'");
    	return view('admin.users.user_detail')->with('detail',$detail);

    }
    
    public function change_mobile_no(Request $request){
       $input = $request->all();
       if($input['mobile_no'] !== ''):
           
           $user = User::find($input['user_id']);
        //   dd($user->mobile_no);
           $user->mobile_no = $input['mobile_no'];
           $user->save();
           return back()->with('success', 'Contact info changed successfully!');
           endif;
           return back();
    }
    public function changePassword(Request $request){
        $data = $request->all();
        $sql = DB::select("SELECT password FROM `users` WHERE id=1");
        $dbpassword = $sql[0]->password;
        $oldpassword = $data['oldpwd'];
        $hash = Hash::check($oldpassword, $dbpassword);
        if($hash == 1){
            if($data['newpwd'] == $data['confirmpwd']){
                $newPassword = Hash::make($data['newpwd']);
                $sql1 = DB::table('users')->where('id',1)->update(['password' => $newPassword]);
                return back()->with('success', 'Password changed successfully!');
            }
            else{
                return back()->with('error', 'Password and  confirm password does not matched');
            }
        }
        else{
            return back()->with('error', 'Old password does not Matched!');
        }
    }

    public function changeImage(Request $request){
        $request = $request->all();
        $image_name = time().'.'.$request['image']->extension();  
        $request['image']->move(public_path('uploads/admin'), $image_name);
        $sql1 = DB::table('users')->where('id',1)->update(['profile_picture' => $image_name]);
        return back()->with('success2', 'Profile updated Successfully!');
    }

    public function report(){
    	return view('admin.report-management');
    }
    public function setting(){
        $users = DB::select('select id,profile_picture from users where id=1');
    	return view ('admin.setting')->with('user',$users);
    }
    public function deletImage(Request $request){
        $data = $request->id;
        $sql1 = DB::table('users')->where('id',$data)->update(['profile_picture' => '']);
        return back()->with('success2', 'Image deleted Successfully!');
        
    }
    
    
    public function ReportManagement(){
        $contact_us = ContactUs::get();
        return view('admin.report-management',compact('contact_us'));
    }

   

}
