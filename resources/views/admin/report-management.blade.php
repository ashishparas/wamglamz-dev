@extends('layouts.backend')

                                @php
                                    session()->put('header','Report Management');
                                @endphp

@section('content')

                        <div class="card border-0 pb-0">
                             <div class="card-body"> 
                                <div class="table-responsive">
                                    <table id="example3" class="display mb-3" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th width="100px">Name</th>
                                                <th>Email Id</th>
                                                <th>Created at</th>
                                                <!--<th>Phone No</th>-->
                                                <th>Subject</th>
                                                <th >Message</th>
                                                
                                                
                                                
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contact_us as $report)
                                         
                                            <tr>
                                                <td><?php echo $report['name']; ?></td>
                                                <td><strong><?php echo $report['email']; ?></strong></td>
                                                 <td><?php echo $report['created_at']; ?></td>
                                                <!--<td><strong>9875845852</strong></td>-->
                                                <td><?php echo $report['subject']; ?></td>
                                                <td style="word-wrap:break-word"><?php echo $report['message']; ?></td>
                                               
                                                
                                                <td><a href="mailto:admin@wamglam.com" class="btn btn-primary btn-xs sharp me-1">Report</a></td>												
                                            </tr>
                                            @endforeach
                                          
                                     
                                        </tbody>
                                    </table>
                                </div>
                        </div>
					</div>
                    </div>
                    
                    
                    <!-- Modal -->
    <div class="modal fade" id="reportModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body pt-2 pb-0">
                    <div class="form-group">
                        <label for="exampleTextarea">To</label>
                        <input type="text" class="form-control" placeholder="">
                      </div>
                    <div class="form-group mt-3">
                        <label for="exampleTextarea">Message</label>
                        <textarea class="form-control form-height" id="exampleTextarea" rows="5"></textarea>
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
                    
        @endsection
