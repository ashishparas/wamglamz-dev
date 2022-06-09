@extends('layouts.backend')



@section('content')


        <div class="card-body">
            <div class="basic-form">
                    <form action="{{url('admin/edit-blog-details')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="blog_id" value="{!!$blog->id!!}">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Enter Blog Name</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $blog->title;  ?>">
                            </div>
                          
                        <div class="">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Enter Blog description</label>
                              
                                <div class="card-body custom-ekeditor p-0">
                                   <textarea  name="description"><?php echo $blog->description; ?></textarea>
                            </div>
                            
                            
                            
                            
                            </div>
                           
                            <div class=" mt-3">
                                <label class="form-label">Upload blog Image</label>
                              
                                <div class="upload_blog_img"> <img src="{{ asset('uploads/admin/blogs/'.$blog->photo) }}" alt="" style="width: 201px; height: 200px;margin-bottom: 10px;">
                        
                          <span class="del_icon"> <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
                                <g id="trash" transform="translate(-2 -2)">
                                  <rect id="Rectangle_859" data-name="Rectangle 859" width="22" height="27" transform="translate(8 8)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                  <line id="Line_48" data-name="Line 48" x2="32" transform="translate(3 8)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                  <line id="Line_49" data-name="Line 49" x2="7" transform="translate(15 3)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                  <line id="Line_50" data-name="Line 50" y2="12" transform="translate(15 14)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                  <line id="Line_51" data-name="Line 51" y2="12" transform="translate(22 14)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </g>
                              </svg>
                              </span>


                        </div>
                            
                            </div>
                        </div>
                      
                    
                        <button type="submit" class="btn btn-primary blog_btn btn-rounded"><h4><b style="color:white">Update</b></h4></button>
                
                </div>
                
                    </form>
                            </div>

 <script>
                        CKEDITOR.replace( 'description' );
                </script>

@endsection