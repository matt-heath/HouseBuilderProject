@extends('layouts.admin')

@section('content')

    <h1>Create Users</h1>

    {!! Form::open(['method'=>'POST', 'action'=> 'AdminUsersController@store','files'=>true]) !!}

        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control'])!!}
        </div>


        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::email('email', null, ['class'=>'form-control'])!!}
        </div>

        <div class="form-group">
            {!! Form::label('role_id', 'Role:') !!}
            {!! Form::select('role_id', [''=>'Choose Options'] + $roles , null, ['class'=>'form-control roleSelect select'])!!}
        </div>

        <div class="form-group" id="consultantDetails">

        </div>


        <div class="form-group">
            {!! Form::label('is_active', 'Status:') !!}
            {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 0 , ['class'=>'form-control'])!!}
        </div>


        <div class="form-group">
            {!! Form::label('password', 'Password:') !!}
            {!! Form::password('password', ['class'=>'form-control'])!!}
        </div>


        <div class="form-group">
            {!! Form::submit('Create User', ['class'=>'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select').select2();

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
        });
    </script>
@endsection