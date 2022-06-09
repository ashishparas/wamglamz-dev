@extends('layouts.backend')

                @php
                    session()->put('header','User Management')
                @endphp

@section('content')
                            <div class="card-body pb-0">
                                <div class="table-responsive">
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
                                            @foreach($data as $data1)
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="images/photo1.png" alt="">{{$data1->name}}</td>
                                                <td><strong>{{$data1->mobile_no}}</strong></td>
                                                <td><strong>{{$data1->email}}</strong></td>
                                                <td><strong><?php
                                                $date=date_create($data1->created_at);
                                                echo date_format($date,"M/d/Y H:i");
                                                ?></strong></td>
                                                <td>
													<div class="d-flex justify-content-space-around">
														<a href="user-detail/{{$data1->id}}" class="btn btn-primary btn-xs sharp me-1">View Detail</a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#suspendModal">Suspend</a>
													</div>												
												</td>												
                                            </tr>
                                            @endforeach
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        @endsection
