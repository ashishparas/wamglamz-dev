<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<!-- PAGE TITLE HERE -->
	<title>{{ config('app.name') }}</title>
	<!-- Style css -->
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
	    <!-- Datatable -->
	<link href="{{asset('admin/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
</head>
<body>
        <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="waviy">
		   <span style="--i:1">L</span>
		   <span style="--i:2">o</span>
		   <span style="--i:3">a</span>
		   <span style="--i:4">d</span>
		   <span style="--i:5">i</span>
		   <span style="--i:6">n</span>
		   <span style="--i:7">g</span>
		   <span style="--i:8">.</span>
		   <span style="--i:9">.</span>
		   <span style="--i:10">.</span>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{route('home')}}" class="brand-logo">
				<img src="{{asset('admin/images/icon-wamglam.png')}}" width="74px">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->

        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a href="{{route('home')}}">
							<i class="flaticon-025-dashboard"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                    </li>
                    <li><a href="{{url('/admin/artist-management')}}">
						<i class="flaticon-050-info"></i>
							<span class="nav-text">Artist Management</span>
						</a>
                    </li>
                    <li><a href="{{url('admin/user-management')}}">
						<i class="flaticon-381-user"></i>
							<span class="nav-text">User Management</span>
						</a>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-041-graph"></i>
                        <span class="nav-text">Services Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{url('admin/main-category')}}">Main Category</a></li>
                        <li><a href="{{url('admin/sub-category')}}">Sub Category Services</a></li>
                    </ul>
                </li>
                <li><a href="{{url('admin/payment-transaction')}}">
                    <i class="flaticon-086-star"></i>
                    <span class="nav-text">Payment Transaction </span>
                </a>
            </li>
            
            <li><a href="{{url('admin/blogs')}}">
                    <i class="flaticon-381-list"></i>
                    <span class="nav-text">Blogs </span>
                </a>
            </li>
            
            <li><a href="{{url('admin/report-management')}}">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Report Management</span>
                </a>
            </li>
            <li><a href="{{url('admin/setting')}}">
                    <i class="flaticon-381-settings"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
                </ul>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
            <div class="header">
            <div class="header-content">
               <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                               <?php
                                    echo (session()->has('header'))? session()->get('header'): 'No-Header';
                               ?>
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                        
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                 
                                    @if(Auth::user()->profile_picture !== '')
                                        <img src="{{asset('uploads/admin/'.Auth::user()->profile_picture)}}" alt=""  width="40px;" />
                                    @else
                                        <img src="http://saurabh.parastechnologies.in/wamglam/public/uploads/admin/no-image-icon-4.png" width="40px;">  
                                    @endif
                                        
                                   
                                  
                                </a>
                                <div class="dropdown-menu dropdown-menu-end pb-0">
                                    <div id="dlab_W_Notification1" class="widget-media dlab-scroll p-3">
            <ul class="timeline">
        <li>                            
                                <a class="#" style ="Color:White" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                   <h5><img src="{{asset('admin/images/logout.svg')}}" width="20px"> Logout</h5>
                                </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                 </li>
            </ul>
                </div>
                                </div>
                            </li>
                    
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row as-->
            <div class="container-fluid">
                    <div class="row invoice-card-row">
                            @yield('content')
                    </div>
			
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
		
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
		
            <div class="copyright">
                <p>Copyright &copy <?php echo  date('Y'); ?> Designed &amp; Developed by</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
                           <!-- Modal -->
                           <div class="modal fade" id="suspendModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <p class="text-center pt-5"><img src="{{asset('admin/images/suspended.svg')}}" width="84px"></p>
                                    <div class="modal-body"><h3 class="text-center">Are you sure you want want to suspend this user</h3></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light w-50" data-bs-dismiss="modal">Yes</button>
                                        <button type="button" class="btn btn-primary w-50" data-bs-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('admin/js/global.min.js')}}"></script>
	<script src="{{asset('admin/js/jquery.nice-select.min.js')}}"></script>
	<!-- Dashboard 1 -->
    <script src="{{asset('admin/js/custom.min.js')}}"></script>
	<script src="{{asset('admin/js/dlabnav-init.js')}}"></script>
	<script src="{{asset('admin/js/demo.js')}}"></script>
		
    <!-- Datatable -->
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/datatables.init.js')}}"></script> 
    <!--<script src="{{asset('admin/js/ckeditor.js')}}"></script>-->
    <!--<script src="{{ URL::asset('admin/js/ckeditor.js') }}"></script>-->
</body>
</html>