@extends('layouts.backend')


@section('content')

            @php
                    session()->put('header', 'Blogs Management');
                @endphp


    <div class="card-body pb-0">
                                <div class="table-responsive">

   <div class="add_blog_btn">  <a  href="{{url('admin/create-blog')}}"type="button" class="btn btn-primary blog_btn btn-rounded">  <i class="flaticon-381-plus"> </i>Add New Blog</a></div>

                                    <table id="example3" class="display mb-3" style="min-width: 845px">
                                        <thead>
                                            <tr>

                                                <th>Image</th>
                                                <th> Name</th>

                                               

                                                <th width="400px">Description</th>
                                                <th >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php
                                     
                                       
                                       if($blogs->isEmpty() !== true): ?>
                                            @foreach($blogs as $blog)
                                            @php
                                                $image = (!$blog->photo)? 'no-image.png': $blog->photo;
                                            @endphp
                                            <tr>
                                                <td><img class="blog_img"  src="{{asset('uploads/admin/blogs/'.$image)}}" width="50px" height="50px" style="border-radius: 10px;" alt="blog image"> </td>
                                                <td><strong>{{$blog->title}}</strong></td>
                                              
                                                <td><div class="des_overhiddin">{!!$blog->description!!}</div></td>
                                              
                                                <td>
													<div class="d-flex justify-content-space-around align-items-center blog_action_btn">
                                                       <a href="{{ url('admin/edit-blog',$blog['id']) }}" class="btn btn-default shadow btn-xs sharp me-2"> 
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12.063" height="12.063" viewBox="0 0 12.063 12.063">
                                                                <g id="_2561427_edit_icon" data-name="2561427_edit_icon" transform="translate(-1.55 -1.55)">
                                                                  <path id="Path_30731" data-name="Path 30731" d="M12.046,9.95v2.98a1.116,1.116,0,0,1-1.116,1.116H3.116A1.116,1.116,0,0,1,2,12.93V5.116A1.116,1.116,0,0,1,3.116,4H6.1" transform="translate(0 -0.884)" fill="none" stroke="#969ba0" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.9"/>
                                                                  <path id="Path_30732" data-name="Path 30732" d="M13.581,2l2.233,2.233L10.233,9.814H8V7.581Z" transform="translate(-2.651)" fill="none" stroke="#969ba0" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.9"/>
                                                                </g>
                                                              </svg>
                                                              
                                                              
                                                              
                                                                Edit</a>
                                                        <a href="" class="btn btn-danger shadow btn-xs sharp me-2" data-bs-toggle="modal" data-bs-target="#DeleteBlog-{{ $blog->id }}"> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
                                                            <g id="Group_38412" data-name="Group 38412" transform="translate(-7625.5 -2166.5)">
                                                              <g id="trash" transform="translate(7623 2164)">
                                                                <rect id="Rectangle_859" data-name="Rectangle 859" width="10" height="11" transform="translate(5 5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                                                <line id="Line_48" data-name="Line 48" x2="13" transform="translate(3 5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                                                <line id="Line_49" data-name="Line 49" x2="3" transform="translate(8 3)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                                                <line id="Line_50" data-name="Line 50" y2="5" transform="translate(8 8)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                                                <line id="Line_51" data-name="Line 51" y2="5" transform="translate(11 8)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                                              </g>
                                                            </g>
                                                          </svg>
                                                          
                                                          Delete</a>

                                                        <a href="{{url('admin/view-blog',['id' => $blog->id])}}" class="btn btn-primary btn-xs sharp me-1">View Detail</a>
													</div>												
												</td>												
                                            </tr>
                                            
                        <div class="modal fade" id="DeleteBlog-{{ $blog->id }}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <p class="text-center pt-5"><img src="{{asset('admin/images/suspended.svg')}}" width="84px"></p>
                                    <div class="modal-body"><h3 class="text-center">Are you sure you want want to Delete this Blog</h3></div>
                                    <div class="modal-footer">
                                        <button type="button" value="yes" data-id="{{ $blog->id }}"  class="btn btn-danger light w-50 yes" data-bs-dismiss="modal">Yes</button>
                                        <button type="button" value="no"  class="btn btn-primary w-50 no" data-bs-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            
                                            
                                            @endforeach
                                          
                                          <?php endif; ?>
                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>



 <!-- Modal -->
                           
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
              
              <script>
              
            $(document).ready(function(){
                
                $(".yes").click(function(){
                        delete_id =   $(this).attr('data-id');
                        console.log(delete_id);
                            $.ajax({
                                url:"{{ url('admin/delete-blog') }}",
                                method:'GET',
                                data:{delete_id: delete_id},
                                success:function(){
                                    location.reload();
                                }
                            });
                      });
                });
                

        $(".des_overhiddin").each(function() {
             if($(this).text().length > 100) {
               $(this).text($(this).text().substr(0,100)+"...");
             }
     });
                
                
              </script>




@endsection