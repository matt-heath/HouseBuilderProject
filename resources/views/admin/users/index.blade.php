@extends('layouts.admin')

@section('title')
    <h1>Users</h1>
@endsection

@section('content')

    @if(Session::has('deleted_user'))
        <p class="bg-danger">{{session('deleted_user')}}</p>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->count())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="pull-right">
        <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal' id='modalClick'><i class="fa fa-fw fa-plus"></i> Add user account</button>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User Account</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact','data-toggle'=>'validator'])!!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name', null, ['data-error' => "Please input the users full name",'class'=>'form-control', 'required', 'placeholder'=>'Full Name'])!!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', null, ['data-error' => "Please input a valid email address",'class'=>'form-control', 'required', 'placeholder'=> 'Email Address'])!!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('role_id', 'Role:') !!}
                        {!! Form::select('role_id', $roles , null, ['data-error' => "Please choose a user role", 'required','class'=>'form-control roleSelect select','placeholder' => 'Select user role'])!!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group" id="consultantDetails"></div>
                    <div class="form-group" id="supplierDetails"></div>
                    <div class="form-group" id="supplierName"></div>
                    <div class="form-group">
                        {!! Form::label('is_active', 'Status:') !!}
                        {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 1 , ['data-error' => "Please activate/deactivate the user account", 'required', 'class'=>'form-control'])!!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password:') !!}
                        {!! Form::password('password', ['data-minlength'=>'6','required','class'=>'form-control', 'placeholder'=>'Password'])!!}
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputPasswordConfirm', 'Confirm Password:') !!}
                        {!! Form::password('inputPasswordConfirm', ['data-match'=>'#password','data-match-error'=>"Whoops, these passwords don't match",'required','class'=>'form-control', 'placeholder'=>'Confirm Password'])!!}
                        <div class="help-block with-errors"></div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--{!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}--}}
                    {{--</div>--}}
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        {!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}
{{--                        {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addUser']) !!}--}}
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <br><br>
    <div class="table-responsive">
        <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Updated</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @if($users)
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role ? $user->role->name : 'User has no role'}}</td>
                        <td>{{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>{{$user->updated_at->diffForHumans()}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                            <div class="btn-group">
                                {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminUsersController@destroy', $user->id], 'id'=> 'confirm_delete_'.$user->id]) !!}
                                {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$user->id .')']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('.select').select2();
            var table = $('#myTable').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ],
                // "processing": true,
                // "serverSide": true,
                // "ajax": {"url":"/getUsers","dataSrc":""},
            });

            $('.roleSelect').on('change',function(e) {
                e.preventDefault();
                // console.log("Role changed...");

                var role = $(this).val();

                // console.log(role);
                if(role === '5') {
                    console.log("EXTERNAL CONSULTANT!!!!");
                    $('#consultantDetails').append('' +
                        '{!! Form::label('consultant_description', 'Consultant Description:') !!}' +
                        '{!! Form::textarea('consultant_description', null, ['class'=>'form-control name_list', 'placeholder' => 'Consultant Description', 'rows' => 2, 'cols' => 40]) !!}'
                    );
                }else{
                    console.log("NOT EXT CONSULTANT");
                    $('#consultantDetails').html(" ");
                }
            });

            $('#addUser').on('click', function (e) {
                e.preventDefault();
                var data = $('form.contact').serialize();

                console.log(data);
                $.ajax({
                    type:"POST",
                    url:'/addUser',
                    data: data,
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        console.log('USER ADDED'+ data.id + data.name);
                        // $('.consultantSelect').append('<option value="'+ data.id + '" selected="selected">' + data.name +'('+data.email+') </option>');
                        $('#myModal').modal('hide');
                        location.reload();
                        // table.ajax.reload();
                        // table.ajax.url( '/getUsers' ).load();
                    },
                    error: function(data){

                    }
                })
            });
        });

        function confirmDelete(id) {
            event.preventDefault();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                buttonsStyling: true
            }).then((result) => {
                if (result.value) {
                swal({
                    title: 'Deleted!',
                    text: 'User has been deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 3000
                }).then(function () {
                    $("#confirm_delete_"+id).off("submit").submit()
                })
                // $("#confirm_delete_"+id).off("submit").submit()
                // result.dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
            }else if (result.dismiss === 'cancel') {

            }
        });
        }
    </script>

@endsection