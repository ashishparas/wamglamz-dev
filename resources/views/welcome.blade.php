<!doctype html>
<html lang="en">
  <head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('public/website/css/bootstrap.min.css')}}">
	<!-- style CSS -->
	<link rel="stylesheet" href="{{asset('public/website/css/style.css')}}">  
	<link rel="stylesheet" href="{{asset('public/website/css/responsive.css')}}">  

  <!--owl-slider-->
  <link rel="stylesheet" href="{{asset('public/website/css/owl.carousel.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('public/website/css/owl.theme.default.min.css')}}"/>
	<title>{{ config("app.name") }}</title>
  </head>
  <body>
      <!--header-->
      <section class="head_banner">
          <div class="container">
            <!--navbar-->
            <nav class="navbar navbar-expand-lg navbar-light  ">
              <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="{{asset('public/website/img/ht-logo.png')}}" alt="icon"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse main_nav">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0 " id="navbar">
                    <li class="nav-item">
                      <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-white" href="#feature">Features</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-white" href="#how_it_works">How it works</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-white" href="#our_app">Our App</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-white" href="#contact_us">Contact Us</a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
            <!--navbar-->
            <!--banner-->
            <div class="banner_wrap">
              <div class="container">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="banner_box text-white">
                      <h1>WamGlamz – Your Beauty Salon In Your Pocket!</h1>
                      <p>The Ultimate Beauty Solution. Book Your Appointment when you want, from where you want, with whom you want! Download it, and get glamorous!</p>
                      <div class="play_store_btns">
                        <a  class="google_store d-inline-block me-3" href="https://apps.apple.com/ca/app/wamglamz/id1613316234"><img src="{{asset('public/website/img/apple-store.png')}}" alt="buttons"/></a>
                        <a  class="apple_store d-inline-block" href="https://play.google.com/store/apps/details?id=com.wamglamz"><img src="{{asset('public/website/img/google-store.png')}}" alt="buttons"/></a>
                      </div> 
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="banner_img">
                      <img class="w-100" src="{{asset('public/website/img/banner-img.png')}}" alt="image" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--banner-->
          </div>
      </section>
      <!--header-->

      <!---feature--->
      <section class="features_wrap" >
        <div class="container" id="feature">
          <div class="common_hd_wrap text-center">
            <h6>Our Features</h6>
            <h2>What Makes Us Different</h2>
            <p>WamGlamz has been designed with the objective of providing “all” the makeup services by enrolling the top beauty service providers under one roof</p>
          </div>
          <div class="feature_boxes pt-5">
            <div class="row">
              <div class="col-md-4 col-lg-4 col-sm-12">
                <div class="feature_box text-center">
                  <img src="{{asset('public/website/img/feature1.png')}}" alt="image" />
                  <h4>Search Around You</h4>
                  <p>Our state of the art system suggests makeup artist listing based on zip code</p>
                </div>
              </div>
              <div class="col-md-4 col-lg-4 col-sm-12">
                <div class="feature_box text-center">
                  <img src="{{asset('public/website/img/feature2.png')}}" alt="image" />
                  <h4>Variety of Services</h4>
                  <p>Ranging from makeup to beauty spa services and much more, we have them all</p>
                </div>
              </div>
              <div class="col-md-4 col-lg-4 col-sm-12">
                <div class="feature_box text-center">
                  <img src="{{asset('public/website/img/feature3.png')}}" alt="image" />
                  <h4>Free Signup</h4>
                  <p>Sign up for free with three affordable packages based on your requirements</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!---feature--->

      <!---How-it-works--->
      <section class="work_wrap" id="how_it_works">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12">
              <div class="video_work_wrap">
                <div class="work_hd common_hd_wrap">
                  <h6 class="">Know More</h6>
                  <h2>How It Works</h2>
                </div>
                <p class="mb-2">
                  WamGlamz operates on a subscription-based model where the users can sign up and register for free, and after purchasing the subscription, they can not only explore makeup artists, salons, spa’s, massage parlors, tanning services, brow extensions, microblading, tattoos, and many other such institutions based on their zip code but also book appointments, view the ratings and reviews of the selected artist/institute, along with easy tracing of their bookings and appointments which includes rescheduling.

                </p>
                <p class="mb-2">
                  The same goes for our esteemed service providers who, rather than having to create their own website, can register with us and offer their services to a wider audience through our platform. So, whether you are a service provider or a service consumer, WamGlamz is a single platform to solve the whole equation for you.
                </p>
                <ul class="feature_list list-unstyled">
                  <li class="position-relative">No need to install a ton of beauty or salon apps!</li>
                  <li class="position-relative">One-stop, one place, one app… WamGlamz!</li>
                </ul>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
              <div class="work_videos d-flex justify-content-center align-items-center">
                <a href=""><img src="{{asset('public/website/img/play_btn.png')}}" alt="image" /></a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!---How-it-works--->

      <!---Our-App--->
      <section class="app_sec_wrap" id="our_app">
        <div class="container">
          <div class="common_hd_wrap text-center mb-5">
            <h6>Screenshots</h6>
            <h2>Simple and Elegant Interfacee</h2>
            <p>An easy-to-use interface allows for convenient and hassle-free selection of your desired service provider and the service of your choice for easy booking!</p>
          </div>
          <div class="app_slider_wrap">
            <div class="owl-carousel screen_slider owl-theme">
              <div class="item">
                <div class="screen_box">
                  <img class="w-100" src="{{asset('public/website/img/scrren1.png')}}" alt="image" />
                </div>
              </div>
              <div class="item">
                <div class="screen_box">
                  <img class="w-100" src="{{asset('public/website/img/screen2.png')}}" alt="image" />
                </div>
              </div>
              <div class="item">
                <div class="screen_box">
                  <img class="w-100" src="{{asset('public/website/img/screen3.png')}}" alt="image" />
                </div>
              </div>
              <div class="item">
                <div class="screen_box">
                  <img class="w-100" src="{{asset('public/website/img/screen4.png')}}" alt="image" />
                </div>
              </div>
              <div class="item">
                <div class="screen_box">
                  <img class="w-100" src="{{asset('public/website/img/screen5.png')}}" alt="image" />
                </div>
              </div>
              <div class="item">
                <div class="screen_box">
                  <img class="w-100" src="{{asset('public/website/img/screen6.png')}}" alt="image" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!---Our-App--->

      <!---app-launch--->
      <section class="launch_wrap">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-md-12 col-sm-12">
              <div class="launcher">
                  <div id="countdown">
                    <ul class="timer m-0 p-0">
                        
                        <li class="text-center"><span id="days"></span></li>
                        <li class="text-center"><span id="hours"></span></li>
                        <li class="text-center"><span id="mins"></span></li>
                        <li class="text-center"><span id="secs"></span></li>
                        <!--<li id="end"></li>-->
                        
                        
                        
                      <!--<li class="text-center"><span id="hours"></span>Hours</li>-->
                      <!--<li class="text-center"><span id="minutes"></span>Minutes</li>-->
                      <!--<li class="text-center"><span id="seconds"></span>Seconds</li>-->
                    </ul>
                  </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
              <div class="launch_left text-center"> 
                <img class="mb-4" src="{{asset('public/website/img/dark-square-icon.png')}}" alt="image" />
                <div class="common_hd_wrap launch_hd text-center">
                  <h2 class="text-white">Launching Our App</h2>
                  <p class="mb-5">“We’re out to break the brick-and-mortar model and bring about a digital revolution. Your appointment is just a tap away! No more waiting in lines, and you’re welcome…”</p>
                </div>
                <div class="playstore_sec">
                  <h6 class="text-white">Download Our App</h6>
                  <div class="play_store_btns">
                    <a  class="google_store d-inline-block me-3" href="https://apps.apple.com/ca/app/wamglamz/id1613316234"><img src="{{asset('public/website/img/apple-store.png')}}" alt="buttons"/></a>
                    <a  class="apple_store d-inline-block" href="https://play.google.com/store/apps/details?id=com.wamglamz"><img src="{{asset('public/website/img/google-store.png')}}" alt="buttons"/></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
              <div class="launch_img">
                <img src="{{asset('public/website/img/launch_img.png')}}" alt="image"/>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!---app-launch--->

      <!---contact-wrap--->
      <section class="contact_us_wrap" >
          <div class="container" id="contact_us">
              <div class="contact_us_box">
                <div class="common_hd_wrap text-center">
                  <h6>Contact Us</h6>
                  <h2>Have A Query</h2>
                  
                        @if (\Session::has('msg'))
                        <div class="alert alert-success">
                        <ul>
                        <li>{!! \Session::get('msg') !!}</li>
                        </ul>
                        </div>
                        @endif
                  <p class="mb-5">Feel free to contact us, we would love to answer any question you may have either as a consumer or as a service provider.</p>
                </div>
                <div class="contact_form">
                  <form method="post" action="{{route('contact-us')}}">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="form_controls mb-4">                          
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="form_controls mb-4">                          
                          <label class="form-label">Email</label>
                          <input type="text" name="email" class="form-control" required>
                      </div>
                      </div>
                      <!--<div class="col-md-6 col-lg-6 col-sm-12">-->
                      <!--  <div class="form_controls mb-4">                          -->
                      <!--    <label class="form-label">Phone No.</label>-->
                      <!--    <input type="text" name="phone_no" class="form-control" required>-->
                      <!--</div>-->
                      <!--</div>-->
                      <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form_controls mb-4">                          
                          <label class="form-label">Subject</label>
                          <input type="text" name="subject" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form_controls mb-4">                          
                          <label class="form-label">Message</label>
                          <textarea class="form-control" name="message" placeholder="Type..." required></textarea>
                        </div>                        
                      </div>
                      <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form_btn">            
                          <button type="submit" class="btn">Send</button>
                        </div>                        
                      </div>
                    </div>
                  </form>
                </div>
              </div>
          </div>
      </section>
      <!---contact-wrap--->

      <!---footer--->
      <footer class="footer_wrap">
          <div class="container">
            <div class="footer_sec">
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="footer_menu">
                      <ul class="list-inline text-white">
                        <!--<li class="list-inline-item">About Us</li>-->
                        <!--<li class="list-inline-item">Contact Us</li>-->
                        <!--<li class="list-inline-item">Terms & Conditions</li>-->
                        <!--<li class="list-inline-item">Security</li>-->
                        <!--<li class="list-inline-item">Privacy</li>-->
                      </ul>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="social_media d-flex justify-content-md-end justify-content-lg-end">
                        <a href="" class="facebook_sm">
                          <svg xmlns="http://www.w3.org/2000/svg" width="8.399" height="15.683" viewBox="0 0 8.399 15.683">
                            <path id="fb" d="M9.458,8.821l.436-2.838H7.171V4.141a1.419,1.419,0,0,1,1.6-1.533h1.238V.192A15.1,15.1,0,0,0,7.811,0,3.465,3.465,0,0,0,4.1,3.82V5.983H1.609V8.821H4.1v6.861H7.171V8.821Z" transform="translate(-1.609)" fill="#fff"/>
                          </svg>                          
                        </a>
                        <a href="" class="facebook_sm">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14.824" height="12.04" viewBox="0 0 14.824 12.04">
                            <path id="twitter" d="M13.3,6.381c.009.132.009.263.009.4a8.585,8.585,0,0,1-8.644,8.644A8.586,8.586,0,0,1,0,14.057a6.285,6.285,0,0,0,.734.038,6.085,6.085,0,0,0,3.772-1.3,3.044,3.044,0,0,1-2.841-2.107,3.831,3.831,0,0,0,.574.047,3.213,3.213,0,0,0,.8-.1A3.039,3.039,0,0,1,.6,7.651V7.614A3.06,3.06,0,0,0,1.975,8a3.043,3.043,0,0,1-.941-4.064A8.636,8.636,0,0,0,7.3,7.115a3.43,3.43,0,0,1-.075-.7A3.041,3.041,0,0,1,12.482,4.34a5.982,5.982,0,0,0,1.928-.734,3.03,3.03,0,0,1-1.336,1.674,6.091,6.091,0,0,0,1.75-.47A6.531,6.531,0,0,1,13.3,6.381Z" transform="translate(0 -3.381)" fill="#fff"/>
                          </svg>                                                  
                        </a>
                        <a href="" class="facebook_sm">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16.516" height="12.387" viewBox="0 0 16.516 12.387">
                            <path id="gmail" d="M16.516,5.532V15.854a1.014,1.014,0,0,1-1.032,1.032H14.451V7.519L8.258,11.966,2.064,7.519v9.368H1.032A1.013,1.013,0,0,1,0,15.854V5.532A1.014,1.014,0,0,1,1.032,4.5h.344L8.258,9.489,15.139,4.5h.344a1.014,1.014,0,0,1,1.032,1.032Z" transform="translate(0 -4.5)" fill="#fff"/>
                          </svg>                                                   
                        </a>
                    </div>
                  </div>
                </div>
                <hr class="ft_hr">
                <p class="mb-0 text-white text-center">@ copyright By <span>LionInDigital LLC</span>    |       All Right Reserved</p>
            </div>
          </div>
      </footer>
      <!---footer--->

<script>
    // The data/time we want to countdown to
    var countDownDate = new Date("Mar 4, 2022 16:37:52").getTime();

    // Run myfunc every second
    var myfunc = setInterval(function() {

    var now = new Date().getTime();
    var timeleft = countDownDate - now;
        
    // Calculating the days, hours, minutes and seconds left
    var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
        
    // Result is output to the specific element
    document.getElementById("days").innerHTML = days + "D "
    document.getElementById("hours").innerHTML = hours + "H " 
    document.getElementById("mins").innerHTML = minutes + "M " 
    document.getElementById("secs").innerHTML = seconds + "S " 
        
    // Display the message when countdown is over
    if (timeleft < 0) {
        clearInterval(myfunc);
        document.getElementById("days").innerHTML = ""
        document.getElementById("hours").innerHTML = "" 
        document.getElementById("mins").innerHTML = ""
        document.getElementById("secs").innerHTML = ""
        document.getElementById("end").innerHTML = "TIME UP!!";
    }
    }, 1000);
    </script>


  </body>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="{{asset('public/website/js/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('public/website/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('public/website/js/owl.carousel.min.js')}}"></script>
  <!--<script src="{{asset('website/js/custom.js')}}"></script>-->
    
    <script>
        $(document).ready(function(){
            $("#navbar").children(".nav-item").click(function(){
            $("#navbar").children(".nav-item").children(".nav-link").removeClass("active");    
            $(this).children(".nav-link").addClass("active");

            });
        });
    </script>    

</html>