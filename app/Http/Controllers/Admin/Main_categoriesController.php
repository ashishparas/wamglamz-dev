<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\Main_category;
use App\Subcategory;
use Illuminate\Http\Request;

class Main_categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $category = DB::select('select * from main_categories');
        return view('category.main-category')->with('data',$category);
    }

    public function deleteCategory(Request $request){
        $data=Main_category::find($request->id);
        $data->delete();
        return redirect('admin/main-category')->with('flash_message', 'Category Deleted!');
    }
    
    public function SubCategories(Request $request){
        $categories  =  Main_category::get();
        $subcategory =  Subcategory::with('category')->get();

        return view('category.sub-category', compact('categories', 'subcategory'));
    }

    public function deleteSubcategory(Request $request){
        $data=Subcategory::find($request->id);
        $data->delete();
        return back()->with('error', 'Category Deleted Successfully!');
        //return redirect('admin/sub-category')->with('flash_message', 'Category Deleted!');
    }
    
    
    public function EditSubcategories(Request $request){
            $data = [];
            $input = $request->all();
    
            if ($request->hasFile('image')) {
                      
                    $image = $request->file('image');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/subcategory');
                    $image->move($destinationPath, $name);
                    $data['image'] = $name;
                   
            }
            
               
                    $data["gender"] = $request->gender;
                    $data["category_id"]  = $request->category;
                    $data["title"] = $request->title;
                    // echo '<pre>';
                    // dd($data);
            $blog = Subcategory::where('id', $input['id'])->update($data);
             return back()->with('success','Image Upload successfully');
    }
    
    
    public function EditCategories(Request $request){
     
            $data = [];
            $input = $request->all();
    
            if ($request->hasFile('image')) {
                      
                    $image = $request->file('image');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/category');
                    $image->move($destinationPath, $name);
                    $data['image'] = $name;
                   
            }
            
               
                    $data["slug"] = $request->gender;
                    $data["title"] = $request->title;
            
            $blog = Main_category::where('id', $input['id'])->update($data);
             return back()->with('success','Image Upload successfully');
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('main_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $image_name = time().'.'.$request->image->extension();  
        $request->image->move(public_path('uploads/category'), $image_name);
        $requestData = new Main_category;
        $requestData->title = $request->title;
        $requestData->slug = $request->gender;
        $requestData->image = $image_name;
        $test1 = $requestData->save();
        return redirect('admin/main-category')->with('flash_message', 'Main_category added!');
    }
    
    public function storeSubcategory(Request $request)
    {
        $image_name = time().'.'.$request->image->extension();  
        $request->image->move(public_path('uploads/subcategory'), $image_name);
        $requestData = new Subcategory;
        if($request->category == 'Select Services'){
            return redirect('admin/sub-category')->with('error1', 'Please Select Atleast One Category');
        }
        else{
        $requestData->category_id = $request->category;
        $requestData->gender = $request->gender;
        $requestData->title = $request->title;
        $requestData->image = $image_name;
        $test1 = $requestData->save();
        return redirect('admin/sub-category')->with('flash_message', 'Main_category added!');
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $main_category = Main_category::findOrFail($id);

        return view('main_categories.show', compact('main_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $main_category = Main_category::findOrFail($id);

        return view('main_categories.edit', compact('main_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $main_category = Main_category::findOrFail($id);
        $main_category->update($requestData);

        return redirect('main_categories')->with('flash_message', 'Main_category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Main_category::destroy($id);

        return redirect('main_categories')->with('flash_message', 'Main_category deleted!');
    }
}
