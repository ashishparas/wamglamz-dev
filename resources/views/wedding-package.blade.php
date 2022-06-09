@extends('layouts.backend')



@section('content')

<h2>Wedding Packages</h2>

<div class="card-body pb-0">
                                <div class="table-responsive">
                                <div class="d-flex justify-content-space-around">
										<a href="{{ url('/admin/add-wedding-plan') }}" class="btn btn-primary btn-xs sharp me-1">Add Wedding Plan</a>    
													</div>	
                                    <table id="example3" class="display mb-3" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th width="180px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="images/photo1.png" alt=""></td>
                                                <td><strong></strong></td>
                                                <td><strong></strong></td>
                                                <td><strong></strong></td>
                                                <td>
													<div class="d-flex justify-content-space-around">
														<a href="" class="btn btn-primary btn-xs sharp me-1">View</a>    
													</div>												
												</td>												
                                            </tr>
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>

@endsection