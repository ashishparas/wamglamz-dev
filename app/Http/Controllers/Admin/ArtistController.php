<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Blog;

class ArtistController extends Controller {

 public function artists(){
 	$users = DB::select('select id,name,mobile_no,email, created_at from users where type=2');
 	return view('admin.artist.artist-management')->with('data',$users);
 }
 public function artist_detail(Request $request){
 	$detail = DB::select("SELECT * FROM `users` WHERE id='$request->id'");
 	$availability = \App\Availability::where('user_id', $request->id)->first();
//  	dd($availability->distance_range_price[1]);
 	return view('admin.artist.artist-management-detail')->with('data',$detail);
 }
 
 
 public function blogs(){
        $blogs = Blog::orderBy('created_at','DESC')->get();
      
        return view('admin.blog-management', compact('blogs'));
 }
 
 public function create_blog(){
     return view('admin.create-blog');
 }
 
 public function add_blog(Request $request){
    // dd($request->all());
      $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
        
            return redirect('admin/create-blog')->withErrors($validator)->withInput();
        }else{
            
            $input = $request->all();
    
            if ($request->hasFile('photo')) {
                      
                    $image = $request->file('photo');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/admin/blogs');
                    $image->move($destinationPath, $name);
                    $input['photo'] = $name;
                    $blog = Blog::create($input);
                 
                    return back()->with('success','Image Upload successfully');
            }
         
        }

    
 }
 
 public function view_blog($id){
 
     $blog = Blog::where('id', $id)->first();
     return view('admin.view-blog', compact('blog'));
 }
 
 
     public function edit_blog($id){
        
        $blog = Blog::where('id', $id)->first();
        return view('admin.edit-blog', compact('blog'));
                  
     }
     
    public function edit_blog_details(Request $request){
        $input = $request->all();
        $blog = \App\Blog::findOrFail($input['blog_id']);
        $blog->fill($input);
        $blog->save();
        return redirect()->route('view.blog');    
        
    } 
     
     
    public function delete_blog(){
        
        $delete_id = $_GET['delete_id'];
            
        $blog = Blog::findOrFail($delete_id);
        $blog->delete();
       
    }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
}



