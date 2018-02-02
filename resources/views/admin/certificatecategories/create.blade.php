@extends('layouts.admin')

@section('content')

    <h1>Create Certificate Category</h1>

    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminCertificateCategoriesController@store'])!!}

        <div class="form-group">
            {!! Form::label('name', 'Category Name:')!!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('category_description', 'Category Description:')!!}
            {!! Form::text('category_description', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create Certificate Category', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="row">
        @include('includes.form_error')
    </div>

@endsection