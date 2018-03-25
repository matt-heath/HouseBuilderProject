@extends('layouts.admin')

@section('title')
    <h1>Create Users</h1>
@endsection


@section('content')
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

        <div class="form-group" id="consultantDetails"></div>
        <div class="form-group" id="supplierDetails"></div>
        <div class="form-group" id="supplierName"></div>


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