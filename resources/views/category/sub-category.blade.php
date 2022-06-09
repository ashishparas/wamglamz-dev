@extends('layouts.backend')

        @php
            session()->put('header','Sub Category Services');
        @endphp

@section('content')
 <div class="col-lg-4 col-sm-12 col-xl-4">
                        <div class="card overflow-hidden h-auto">
                            @if(session()->has('error1'))
                                      <div class = "alert alert-danger">
                                     {{ session()->get('error1') }}
                                     </div>
                                @endif
                            <div class="border-0 pb-0 text-center pt-3">
                                <h4 class="card-title text-center w-100 mb-0">Add Sub Category</h4>
                            </div>
                             <form action="{{route('add-sub-category')}}" method="post" enctype="multipart/form-data">
                           @csrf
                            <div class="card-body">
                                <div class="text-center pb-4">
                                    <div class="profile-photo">
                                        <img src="http://saurabh.parastechnologies.in/wamglam/public/uploads/admin/1633432726.jpg" width="150" class="img-fluid rounded-circle"
                                            alt="" id="blsh">
                                        <div class="img-upload">
                                            <a class="btn btn-rounded mt-0 px-5" href="javascript:void();">Upload</a>
                                            <input name="image" required type="file" class="form-control-file" id="exampleFormControlFile1" onchange="document.getElementById('blsh').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label ml-0">
                                            <input type="radio" class="form-check-input" name="gender" value="2" checked="" > Man
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label ml-0">
                                            <input type="radio" class="form-check-input" name="gender" value="1" > Woman
                                        </label>
                                    </div>
                                </div>
                                    <div class="mb-3">
                                        <label class="mb-1 text-left"><strong>Select Catergoy Services</strong></label>
                                        <select name="category" class="form-control form-block" id="exampleFormControlSelect1">
                                            <option>Select Services</option>
                                            @foreach($categories as $category)
                                          
                                            <option value="{{$category->id}}">{{$category->title}}, {{($category->slug == 1)? '(womens)': '(mens)'}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 text-left"><strong>Title</strong></label>
                                        <input type="text" name="title" class="form-control" value="" required>
                                    </div>
                                   
                                    <input type="submit" class="btn btn-outline-primary btn-rounded mt-2 px-5" value="Add"/>
                            </div>
                            </form>
                        </div>


                    </div>

                    <!--********************rightside******************-->
                    <div class="col-xl-8 col-lg-8">
                        <div class="card">
                            <div class="card-header  border-0 pb-0">
                                <h4 class="card-title">List Category</h4>
                                <div>
                                    <select class="form-control form-block" id="exampleFormControlSelect1">
                                        <option>All</option>
                                        <option>All Men</option>
                                      </select>
                                </div>
                            </div>
                             @if(session()->has('error'))
                                      <div class = "alert alert-success">
                                     {{ session()->get('error') }}
                                     </div>
                                @endif
                            <div class="card-body">
                                <div id="dlab_W_Todo1" class="widget-media dlab-scroll height370 ps ps--active-y">
                                    <ul class="timeline">
                                    @foreach($subcategory as $subcategory1)
                                  
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2">
                                                    <img alt="image" width="50" src="{{asset('uploads/subcategory/'.$subcategory1->image)}}">
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-1">{{$subcategory1->title}}</h5>
                                                    <span class="fs-16">{{ $subcategory1->category->title }}</span>
                                                    <p class="mb-0"><span class="fs-14">{{ ($subcategory1->gender == '1')? 'Women': 'Men' }}</span></p>
                                                </div>
                                                <div class="dropdown">
                                                     <a href="#" class="btn btn-primary shadow btn-xs sharp px-2" data-bs-toggle="modal" data-bs-target="#basicModal-{{$subcategory1->id}}">Edit</a>
                                                    <a href="deleteSubcategory/{{$subcategory1->id}}" class="btn btn-danger shadow btn-xs sharp">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                        
                                        <!--Model-->
                                        
                                            <div class="modal fade" id="basicModal-{{$subcategory1->id}}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Catergoy #{{$subcategory1->id}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body pt-2 pb-0">
                    <form action="{{url('admin/edit-subcategories')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$subcategory1->id}}"/>
                        @csrf
                        <div class="card-body">
                        <div class="text-center pb-4">
                            <div class="profile-photo">
                                <img src="{{asset('uploads/subcategory/'.$subcategory1->image)}}" width="150" class="img-fluid rounded-circle" alt="">
                                <div class="img-upload">
                                    <a class="btn btn-rounded mt-0 px-5" href="javascript:void();">Upload</a>
                                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline me-0">
                                <label class="form-check-label ml-0">
                                    <input type="checkbox" class="form-check-input" name="gender" value="2" {{ ($subcategory1->gender == '2')? 'checked':'' }}> Man
                                </label>
                            </div>
                            <div class="form-check form-check-inline me-0">
                                <label class="form-check-label ml-0">
                                    <input type="checkbox" class="form-check-input" name="gender" value="1" {{ ($subcategory1->gender == '1')? 'checked':'' }}> Woman
                                </label>
                            </div>
                            <div class="form-check form-check-inline me-0">
                                <label class="form-check-label ml-0">
                                    <input type="checkbox" class="form-check-input" name="gender" value="" > Both
                                </label>
                            </div>
                        </div>
                            <div class="mb-3">
                                <label class="mb-1 text-left"><strong>Select Catergoy Services</strong></label>
                                <select class="form-control form-block" id="exampleFormControlSelect1" name="category">
                                    <option>Select Services</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ ($category->id == $subcategory1->category_id)? 'selected':'' }} >{{$category->title}}, {{($category->slug == 1)? '(womens)': '(mens)'}}</option>
                                @endforeach
                                  </select>
                            </div>
                            <div class="mb-3">
                                <label class="mb-1 text-left"><strong>Title</strong></label>
                                <input type="text" class="form-control" value="{{$subcategory1->title}}" name="title">
                            </div>
                            <button type="submit" class="btn btn-primary shadow btn-xs sharp px-4">Update</button>
                    </div>    
                    </form>
                    
                </div>
              
            </div>
        </div>
    </div>    
                                        
                                        <!--End Model-->
                                        
                                      @endforeach
                                    </ul>
                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps__rail-y" style="top: 0px; height: 370px; right: 0px;">
                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                        
                    
                    
@endsection