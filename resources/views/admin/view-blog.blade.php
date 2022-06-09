@extends('layouts.backend')


@section('content')
            
            @php
                session()->put('header', 'View Blog');
            @endphp


 <div class="card-body pb-0">
                                <div class="post-details">
									 @php
                                                $image = (!$blog->photo)? 'no-image.png': $blog->photo;
                                            @endphp
									<img src="{{asset('uploads/admin/blogs/'.$image)}}" alt="" class="img-fluid mb-3 blog_big rounded" width="200" height="200">

                                    <h3 class="mb-2 text-black">{{$blog->title}}</h3>
									<!-- <ul class="mb-4 post-meta d-flex flex-wrap">
										
										<li class="post-date me-3"><i class="fa fa-calender"></i>18 Nov 2020</li>
								
									</ul> -->
									<p class="limit_str"></p> 
									<p>{!!$blog->description!!}</p>
									<!--<p>Donec orci arcu, mattis et elit vitae, pharetra efficitur metus. Morbi maximus nulla eu mauris cursus, ac pharetra purus ullamcorper. Nam fermentum ligula orci, sed rhoncus nunc maximus sit amet. </p>-->
								
									<!--<p>Donec orci arcu, mattis et elit vitae, pharetra efficitur metus. Morbi maximus nulla eu mauris cursus, ac pharetra purus ullamcorper. Nam fermentum ligula orci, sed rhoncus nunc maximus sit amet. </p>-->
									<!--<p>Donec orci arcu, mattis et elit vitae, pharetra efficitur metus. Morbi maximus nulla eu mauris cursus, ac pharetra purus ullamcorper. Nam fermentum ligula orci, sed rhoncus nunc maximus sit amet. </p>-->
         <!--                           <p>Donec orci arcu, mattis et elit vitae, pharetra efficitur metus. Morbi maximus nulla eu mauris cursus, ac pharetra purus ullamcorper. Nam fermentum ligula orci, sed rhoncus nunc maximus sit amet. </p>-->
         <!--                           <p>Donec orci arcu, mattis et elit vitae, pharetra efficitur metus. Morbi maximus nulla eu mauris cursus, ac pharetra purus ullamcorper. Nam fermentum ligula orci, sed rhoncus nunc maximus sit amet. </p>-->
								
								</div>
                            </div>






<script>
    
//     var elem = $(".limit_str");
// if(elem) elem.val(elem.val().substr(0,10));
    
</script>






@endsection