@extends('layouts.backend')

@section('content')

                @php
                    session()->put('header', 'Artist Management Detail');
                @endphp
    <div class="container-fluid">
                <div class="row">
                    <!--********************leftside******************-->
                    @foreach($data as $data1)
                    <div class="col-lg-4 col-sm-12 col-xl-4">
                        <div class="card overflow-hidden h-auto pb-3">
                            <div class="text-center p-3 overlay-box "
                                style="background-image: url(images/big/img1.jpg);">
                                <div class="profile-photo profile-block">
                                    <img src="{{asset('uploads/artist/'.$data1->upload_id)}}" class="img-fluid rounded-circle" alt="" width="100px">
                                    <span class="bg-success circle-thick"><img src="{{asset('admin/images/checked.svg')}}" alt="" /></span>
                                </div>
                                <h3 class="mt-3 mb-1 text-white">{{$data1->name}}</h3>
                                <p class="text-white mb-0">Artist Name</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between"><span
                                        class="mb-0">Email</span> <strong class="text-muted">{{$data1->email}}
                                    </strong></li>
                                <li class="list-group-item d-flex justify-content-between"><span
                                        class="mb-0">Contact</span> <strong class="text-muted">{{$data1->mobile_no}} </strong></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="mb-0">Social Link</span>
                                    <div class="d-flex">
                                        <div class="facebook-block mx-2"><img src="{{asset('admin/images/facebook-app-symbol.svg')}}"
                                                alt="" width="15px" /></div>
                                        <div class="facebook-block"><img src="{{asset('admin/images/google.svg')}}" alt="" width="15px" />
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="col-xl-12 col-xxl-12 col-12 text-center">
                                        <div class="form-check custom-checkbox mb-3">
                                            <input type="checkbox" class="form-check-input float-none" id="customCheckBox1" required="" checked disable>
                                            <label class="form-check-label mb-0 pt-0 fs-5" for="customCheckBox1"><strong>Verify Agent</strong></label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="form-check toggle-switch text-end form-switch d-flex align-items-baseline justify-content-center suspend-block">
                                <label class="form-check-label" for="flexSwitchCheckDefault1">Suspend Artist</label>
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault1">
                            </div>
                            <!-- <div class="card-footer border-0 mt-0">                                
                                <button class="btn btn-primary btn-lg btn-block">
                                    <i class="fa fa-bell-o"></i> Reminder Alarm                         
                                </button>       
                            </div> -->
                        </div>

                    </div>

                    <!--********************rightside******************-->
                    <div class="col-xl-8 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                       <li class="nav-item"><a href="#my-posts" data-bs-toggle="tab"
                                                    class="nav-link active show">Time Schedule</a>
                                            </li>
                                        <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                                    class="nav-link">Services</a>
                                            </li>
                                         <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                                                    class="nav-link">Gallergy</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="profile-personal-info pt-4">
                                                    <div class="row mb-3 border-bottom pb-3">
                                                        <div class="col-sm-4 col-5 d-flex align-items-center">
                                                            <h5 class="f-w-500 mb-0">Sunday <span
                                                                    class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <span class="badge light time-schedule">10:00 AM</span>
                                                            <span class="px-3">To</span>
                                                            <span class="badge light time-schedule">09:00 PM</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-3">
                                                        <div class="col-sm-4 col-5 d-flex align-items-center">
                                                            <h5 class="f-w-500 mb-0">Monday <span
                                                                    class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <span class="badge light time-schedule">10:00 AM</span>
                                                            <span class="px-3">To</span>
                                                            <span class="badge light time-schedule">09:00 PM</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-3">
                                                        <div class="col-sm-4 col-5 d-flex align-items-center">
                                                            <h5 class="f-w-500 mb-0">Tuesday <span
                                                                    class="pull-end">:</span></h5>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <span class="badge light time-schedule">10:00 AM</span>
                                                            <span class="px-3">To</span>
                                                            <span class="badge light time-schedule">09:00 PM</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-3">
                                                        <div class="col-sm-4 col-5 d-flex align-items-center">
                                                            <h5 class="f-w-500 mb-0">Wednesday <span
                                                                    class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <span class="badge light time-schedule">10:00 AM</span>
                                                            <span class="px-3">To</span>
                                                            <span class="badge light time-schedule">09:00 PM</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-3">
                                                        <div class="col-sm-4 col-5 d-flex align-items-center">
                                                            <h5 class="f-w-500 mb-0">Thursday <span
                                                                    class="pull-end">:</span></h5>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <span class="badge light time-schedule">10:00 AM</span>
                                                            <span class="px-3">To</span>
                                                            <span class="badge light time-schedule">09:00 PM</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-3">
                                                        <div class="col-sm-4 col-5 d-flex align-items-center">
                                                            <h5 class="f-w-500 mb-0">Friday <span
                                                                    class="pull-end">:</span></h5>
                                                        </div>
                                                        <div class="col-sm-8 col-7">
                                                            <span class="badge light time-schedule">10:00 AM</span>
                                                            <span class="px-3">To</span>
                                                            <span class="badge light time-schedule">09:00 PM</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="about-me" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="basic-list-group mt-4 col-md-6">
                                                        <ul class="list-group">
                                                            <li class="list-group-item active">Women</li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Basic Makeup Package <span
                                                                    class="badge badge-primary badge-pill">$ 41.8</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Organic Spray Tan <span
                                                                    class="badge badge-primary badge-pill">$ 45.5</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Dry Hairstyling <span
                                                                    class="badge badge-primary badge-pill">$ 15</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Haircut and Styling <span
                                                                    class="badge badge-primary badge-pill">$ 15</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Waxing <span class="badge badge-primary badge-pill">$
                                                                    10.65</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="basic-list-group mt-4 col-md-6">
                                                        <ul class="list-group">
                                                            <li class="list-group-item active">Men</li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Basic Makeup Package <span
                                                                    class="badge badge-primary badge-pill">$ 41.8</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Organic Spray Tan <span
                                                                    class="badge badge-primary badge-pill">$ 45.5</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Dry Hairstyling <span
                                                                    class="badge badge-primary badge-pill">$ 15</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Haircut and Styling <span
                                                                    class="badge badge-primary badge-pill">$ 15</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                Waxing <span class="badge badge-primary badge-pill">$
                                                                    10.65</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="profile-settings" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;" data-bs-toggle="modal"
                                                            data-bs-target="#basicModal"><img
                                                                src="images/post_image.png" alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image2.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image3.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image4.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post_image.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image2.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image3.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image4.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"></a> <img src="images/post-image2.png"
                                                            alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image3.png"
                                                                alt="" /></a>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 pt-4">
                                                        <a href="javascript:;"><img src="images/post-image4.png"
                                                                alt="" /></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="replyModal">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Post Reply</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <textarea class="form-control" rows="4">Message</textarea>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light"
                                                        data-bs-dismiss="modal">btn-close</button>
                                                    <button type="button" class="btn btn-primary">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endsection
