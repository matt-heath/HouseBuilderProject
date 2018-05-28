@extends('layouts.admin')

@section('title')
    <h1>Create User Account (Buyer)</h1>
@endsection

@section('content')
    {!! Form::open(['method'=>'POST', 'action'=> 'EstateAgentUsersController@store', 'data-toggle'=>'validator']) !!}


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
        {!! Form::select('role_id_disabled', $roles , null, ['class'=>'form-control', 'disabled'])!!}
        {!! Form::select('role_id', $roles , null, ['class'=>'form-control hidden'])!!}
    </div>

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
        {!! Form::submit('Create Buyer Account', ['class'=>'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}


    {{--@include('includes.form_error')--}}
@endsection