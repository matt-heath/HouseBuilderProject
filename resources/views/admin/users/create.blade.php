@extends('layouts.admin')

@section('title')
    <h1>Create Users</h1>
@endsection


@section('content')
    {!! Form::open(['method'=>'POST', 'action'=> 'AdminUsersController@store','files'=>true, 'data-toggle'=>'validator']) !!}
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

                if(role === '3') {
                    console.log('Supplier');
                    $('#supplierDetails').append(''+
                        '{!! Form::label('supplier_company_name', 'Supplier Company Name') !!}' +
                        '{!! Form::text('supplier_company_name', null, ['class'=>'form-control']) !!}'
                    );
                    $('#supplierName').append(''+
                        '{!! Form::label('supplier_type', 'Supplier Type') !!}' +
                        '{!! Form::select('supplier_type', ['' => 'Select a supplier type', 'Kitchen'], null, ['class'=>'form-control dynamicSelect']) !!}'
                    );
                    $('.dynamicSelect').select2();
                }else{
                    console.log("Not supplier");
                    $('#supplierDetails').html(" ");
                }
            });
        });
    </script>
@endsection