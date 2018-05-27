@extends('layouts.admin')

@section('title')
    <h1>Edit User</h1>
@endsection


@section('content')
    <div class="row">

        <div class="col-sm-12">

            {!! Form::model($user,['method'=>'PATCH', 'action'=> ['EstateAgentUsersController@update', $user->id], 'data-toggle'=>'validator']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class'=>'form-control', 'required'])!!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::email('email', null, ['class'=>'form-control', 'required'])!!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::label('role_id', 'Role:') !!}
                {!! Form::select('role_id_disabled', $roles , null, ['class'=>'form-control', 'disabled'])!!}
                {!! Form::select('role_id', $roles , null, ['class'=>'form-control hidden'])!!}
            </div>
            <div class="form-group">
                {!! Form::label('is_active', 'Status:') !!}
                {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), null , ['class'=>'form-control', 'required'])!!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', ['data-minlength'=>'6','class'=>'form-control', 'placeholder'=>'Password'])!!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::label('inputPasswordConfirm', 'Confirm Password:') !!}
                {!! Form::password('inputPasswordConfirm', ['data-match'=>'#password','data-match-error'=>"Whoops, these passwords don't match",'class'=>'form-control', 'placeholder'=>'Confirm Password'])!!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::submit('Edit User', ['class'=>'btn btn-primary col-sm-3']) !!}
            </div>

            {!! Form::close() !!}

            {!! Form::open(['method'=>'DELETE', 'action'=>['EstateAgentUsersController@destroy', $user->id], 'id'=> 'confirm_delete_'.$user->id])!!}

            <div class="form-group">
                {!! Form::submit('Delete User', ['class'=>'btn btn-danger col-sm-3', 'onclick'=>'confirmDelete(' .$user->id .')']) !!}
            </div>

            {!! Form::close() !!}

        </div>

    </div>


    {{--<div class="row">--}}
        {{--@include('includes.form_error')--}}
    {{--</div>--}}
@endsection

@section('script')

    <script>
        function confirmDelete(id) {
            // console.log(id);
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
                swal(
                    'Deleted!',
                    'User has been deleted.',
                    'success'
                )
                $("#confirm_delete_"+id).off("submit").submit()
                // result.dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
            } else if (result.dismiss === 'cancel') {

            }
        })
        }
    </script>
@endsection