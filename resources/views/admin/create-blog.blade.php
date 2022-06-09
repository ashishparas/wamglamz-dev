@extends('layouts.backend')



@section('content')

            @php
                session()->put('header', 'Create Blogs');
            @endphp

       
       <div class="col-xl-8 col-xxl-8">
						<div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Please enter the blog detail </h4>
                                @if(Session::has('success'))
                                <div class="alert alert-success">{{Session::get('success')}}</div>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{url('admin/add-blog')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Enter Blog Name</label>
                                                <input type="text" name="title" class="form-control" placeholder="" required>
                                            </div>
                                          
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Enter Blog description</label>
                                             
                                            <div class="card-body custom-ekeditor p-0">
                                                   <!--<div ></div>-->
                                                   <textarea  name="description"></textarea>
                                                    
                                                </div>
                                            </div>
                                           
                                            <div class=" mt-3">
                                                <label class="form-label">Upload blog Image</label>
                                                <div class="form-file position-relative">

                                                    <input type="file" name="photo" class="form-file-input form-control" required>
                                                    <!--<span class="input-group-text upload_btn">Upload</span>-->
                                                </div>
                                              
                                            </div>
                                        </div>
                                      
                                    
                                        <button type="submit" class="btn btn-primary blog_btn btn-rounded">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
       <script>
                        CKEDITOR.replace( 'description' );
                </script>

@endsection

