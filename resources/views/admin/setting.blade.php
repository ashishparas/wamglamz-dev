@extends('layouts.backend')

                                    @php
                                        session()->put('header','Change Password');
                                    @endphp

@section('content')

                    <!--********************leftside******************-->
                    <div class="col-lg-7 col-sm-12 col-xl-7">
                        <div class="card overflow-hidden h-auto">
                          @if(session()->has('error'))
                                      <div class = "alert alert-danger">
                                     {{ session()->get('error') }}
                                     </div>
                                @endif

                                 @if(session()->has('success'))
                                     <div class="alert alert-success">
                                     {{ session()->get('success') }}
                                     </div>
                                @endif
                             <form action="{{route('admin/change-password')}}" method="post">
                             @csrf
                            <div class="card-body">
                                
                                <div class="mb-3">
                                    <label class="mb-1 text-left fs-4"><strong>Enter Old Password</strong></label>
                                    <input type="text" name="oldpwd" class="form-control" value="" placeholder="Enter Old Password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1 text-left fs-4"><strong>Enter New Password</strong></label>
                                    <input type="text" name="newpwd" class="form-control" value="" placeholder="Enter New Password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1 text-left fs-4"><strong>Confirm New Password</strong></label>
                                    <input type="text" name="confirmpwd" class="form-control" value="" placeholder="Confirm New Password" required>
                                </div>
                                <input type="submit" class="btn btn-primary btn-rounded mt-2 px-5" value="Add"/>
                           
                            </div>
                             </form>
                        </div>

                    </div>
                    <!--********************rightside******************-->
                    <div class="col-xl-5 col-lg-5">
                        <div class="card overflow-hidden h-auto pb-3">
                        <div class="card-body p-0">
                            @if(session()->has('success2'))
                                      <div class = "alert alert-success">
                                     {{ session()->get('success2') }}
                                     </div>
                                @endif
                                
                        
                            <form action="{{route('change-image')}}" method="post" enctype="multipart/form-data">
                                @csrf
                        <div class="ms-panel">
                            <div class="photo-img">
                                @foreach($user as $image)
                                
                                @if($image->profile_picture == '')
                                    <img id="admin" alt="" src="http://saurabh.parastechnologies.in/wamglam/public/uploads/admin/no-image-icon-4.png">
                                @else
                                    <img id="admin" alt="image" src="{{asset('uploads/admin/'.$image->profile_picture)}}">
                                @endif
                                <h2><a href="deletImage/{{$image->id}}"><i class="flaticon-381-trash"></i></a></h2>
                                @endforeach
                                </div>
                                <div class="upload-but save-upload-but w-50 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary rounded-pill">Upload</button>
                                    <input type="file" name="image" required class="form-control-file" id="exampleFormControlFile1" onchange="document.getElementById('admin').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                <div class="upload-but w-50 d-flex justify-content-start">
                                  
                                    <input type="submit"class="btn btn-primary rounded-pill" value="Save"/>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
               
        @endsection
