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
        {!! Form::select('role_id', [''=>'Choose Options'] + $roles , null, ['class'=>'form-control roleSelect'])!!}
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


    {{--@include('includes.form_error')--}}



@endsection

@section('script')
    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        //
        // //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
        // $('.roleSelect').change(function() {
        //     console.log("Changed");
        //
        //     var role=$(this).val();
        //
        //     console.log(role);
        //     // console.log(dev_id);
        //
        //     if(role === 5){
        //         console.log("EXTERNAL CONSULTANT");
        //     }
        // });
        $(document).ready(function() {

            $('.roleSelect').on('change',function(e) {
                e.preventDefault();
                // console.log("Role changed...");

                var role = $(this).val();

                // console.log(role);

                if(role === '5') {
                    console.log("EXTERNAL CONSULTANT!!!!");
                    $('#consultantDetails').append('' +
                        '{!! Form::label('consultant_description', 'Consultant Description:') !!}' +
                        '{!! Form::text('consultant_description', null, ['class'=>'form-control name_list', 'placeholder' => 'Consultant Description']) !!}'
                    );
                }else{
                    console.log("NOT EXT CONSULTANT");
                    $('#consultantDetails').html(" ");
                }
            });
        });
    </script>
@endsection