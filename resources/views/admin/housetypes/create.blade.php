@extends('layouts.admin')

@section('title')
    <h1>Create House Type</h1>
@endsection

@section('content')

    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminHouseTypesController@store', 'files' => true])!!}

        <div class="form-group">
            {!! Form::label('development_id', 'Development Name:')!!}
            {!! Form::select('development_id', [''=>'Choose Development'] + $developments, 'default', ['class'=>'form-control', 'id'=>'developments', 'style'=>'height: 34px !important']) !!}
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

@section('script')

    <script>
        $(document).ready(function(){
            $('#developments').select2();
        });
    </script>

@endsection