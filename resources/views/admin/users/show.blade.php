@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">User</div>
                <div class="card-body">

                    <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
<!--                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>-->
                    <!--                        {!! Form::open([
                                                'method' => 'DELETE',
                                                'url' => ['/admin/users', $user->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete User',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                ))!!}
                                            {!! Form::close() !!}-->
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Mobile</th>
                                    <th>Country</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $user->id }}</td> 
                                    <td> {{ $user->name }}</td>
                                    <td> {{ $user->email }}</td>
                                    <!--{{ $user->image }}-->
                                    <td>
                                        <?php if (!empty($user->image)): ?>
                                            <img width="50" src="<?= url('uploads/users/'.$user->image); ?>">

                                        <?php else: ?>
                                            <img width="50" src="<?= url('noimage.png'); ?>">
                                        <?php endif; ?> 
                                    </td>

                                    <td><?php echo $user->mobile==''? 'No Contact' : $user->mobile ; ?></td>
                                    <td> <?php echo $user->country==''? 'not-selected' : $user->country; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
