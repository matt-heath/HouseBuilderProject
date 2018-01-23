@extends('layouts.admin')

@section('content')

    <h1>Create House Type</h1>

    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminHouseTypesController@store', 'files' => true])!!}

        <div class="form-group">
            {!! Form::label('development_id', 'Development Name:')!!}
            {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('house_type_name', 'House Type Name:')!!}
            {!! Form::text('house_type_name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('house_type_desc', 'House Type Description:')!!}
            {!! Form::text('house_type_desc', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('floor_plan', 'Floor Plan Image:')!!}
            {!! Form::file('floor_plan', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('house_img', 'House Image:')!!}
            {!! Form::file('house_img', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create House Type', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="row">
        @include('includes.form_error')
    </div>

@endsection