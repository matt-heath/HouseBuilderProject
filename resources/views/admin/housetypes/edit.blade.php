@extends('layouts.admin')

@section('content')

    <h1>Edit House Type</h1>



    <div class="col-sm-6">

        {!! Form::model($houseTypes, ['method'=>'PATCH', 'action'=> ['AdminHouseTypesController@update', $houseTypes->id], 'files' => true]) !!}
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
            {!! Form::submit('Update House Type', ['class'=>'btn btn-primary col-sm-6']) !!}
        </div>
        {!! Form::close() !!}


        {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminHouseTypesController@destroy', $houseTypes->id]]) !!}
        <div class="form-group">
            {!! Form::submit('Delete House Type', ['class'=>'btn btn-danger col-sm-6']) !!}
        </div>
        {!! Form::close() !!}

    </div>
@endsection