@extends('layouts.backend')

@php
    session()->put('header','Main Category');
@endphp

@section('content')

  <div class="col-lg-4 col-sm-12 col-xl-4">
                        <div class="card overflow-hidden h-auto">
                            <div class="card-header  border-0 pb-0">
                                <h4 class="card-title">Add Main Category</h4>
                            </div>
                            <form action="{{route('add-main-category')}}" method="post" enctype="multipart/form-data">
                           @csrf
                                <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label ml-0">
                                            <input type="radio" class="form-check-input" name="gender" value="2" checked=""> Man
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label ml-0">
                                            <input type="radio" class="form-check-input" name="gender" value="1"> Woman
                                        </label>
                                    </div>
                                </div>
                                <label class="mb-1 text-left"><strong>Image Upload</strong></label>
                                <div class="input-group">
                                    <div class="form-file border-0">
                                        <input type="file" name="image" class="form-file-input form-control h-auto" required>
                                    </div>
                                </div>
                                <div class="mb-3 pt-4">
                                    <label class="mb-1 text-left"><strong>Title</strong></label>
                                    <input type="text" name="title" class="form-control" value="" required>
                                </div>
                                <div>
                                    <input type="submit" class="btn btn-outline-primary btn-rounded mt-3 px-5" value="Add"/>
                                   

                                </div>
                            </div>
                                </form>
                        </div>

                    </div>

                    <!--********************rightside******************-->
                   
                    <div class="col-xl-8 col-lg-8">
                        <div class="card">
                            <div class="card-header  border-0 pb-0">
                                <h4 class="card-title">List Category</h4>
                            </div>
                            <div class="card-body">
                                <div id="dlab_W_Todo1" class="widget-media dlab-scroll height370 ps ps--active-y">
                                    <ul class="timeline">
                                    @foreach($data as $data1)
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2">
                                                    <img alt="image" width="50" src="{{asset('uploads/category/'.$data1->image)}}">
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mb-1">{{$data1->title}}</h5>
                                                    <span class="fs-14">{{($data1->slug == '1')? 'Women': 'Men'}}</span>
                                                </div>
                                                <div class="dropdown">
                                                     <a href="#" class="btn btn-primary shadow btn-xs sharp px-2" data-bs-toggle="modal" data-bs-target="#basicModal-{{$data1->id}}">Edit</a>
                                                    <a href="deleteCategory/{{$data1->id}}" class="btn btn-danger shadow btn-xs sharp">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                        
                                                            <!--model start-->
                    <form action="{{url('admin/edit-categories')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$data1->id}}" />
                        <div class="modal fade" id="basicModal-{{$data1->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Catergoy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body pt-2 pb-0">
                <div class="card-body">
                    <div class="text-center pb-4">
                        <div class="profile-photo">
                            <img src="{{asset('uploads/category/'.$data1->image)}}" width="150" class="img-fluid rounded-circle" alt="">
                            <div class="img-upload">
                                <a class="btn btn-rounded mt-0 px-5" href="javascript:void();">Upload</a>
                                <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-check-inline me-0">
                            <label class="form-check-label ml-0">
                                <input type="checkbox" class="form-check-input" name="gender" value="{{$data1->slug}}" {{($data1->slug == '2')? 'checked': '' }} > Man
                            </label>
                        </div>
                        <div class="form-check form-check-inline me-0">
                            <label class="form-check-label ml-0">
                                <input type="checkbox" class="form-check-input" name="gender" value="{{$data1->slug}}" {{($data1->slug == '1')? 'checked': '' }}> Woman
                            </label>
                        </div>
                        <div class="form-check form-check-inline me-0">
                            <label class="form-check-label ml-0">
                                <input type="checkbox" class="form-check-input" name="gender" value=""> Both
                            </label>
                        </div>
                    </div>
                   
                        <div class="mb-3">
                            <label class="mb-1 text-left"><strong>Title</strong></label>
                            <input type="text" class="form-control" value="{{$data1->title}}" name="title">
                        </div>
                        
                        <button type="submit" class="btn btn-primary shadow btn-xs sharp px-4">Save </buttpn>
                </div>
            </div>
          
        </div>
    </div>
</div>                    
                    </form>
    
                    
                    
                    <!--Model End-->
                                        
                                        
                                        
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