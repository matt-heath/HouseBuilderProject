@extends('layouts.admin')

@section('content')

    <h1>Create Development</h1>

    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminDevelopmentsController@store', 'files' => true])!!}

        <div class="form-group">
            {!! Form::label('development_name', 'Development Name:')!!}
            {!! Form::text('development_name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('development_location', 'Development Location:')!!}
            {!! Form::text('development_location', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('development_num_plots', 'Number of Plots:')!!}
            {!! Form::number('development_num_plots', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('development_description', 'Development Description:')!!}
            {!! Form::text('development_description', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo_id', 'Example Development Photo:')!!}
            {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create Development', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="row">
        @include('includes.form_error')
    </div>

@endsection