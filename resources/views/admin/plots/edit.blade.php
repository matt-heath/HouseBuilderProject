@extends('layouts.admin')

@section('content')

    <h1>Edit Plot</h1>



    <div class="col-sm-6">

        {!! Form::model($plot, ['method'=>'PATCH', 'action'=> ['AdminPlotsController@update', $plot->id]]) !!}
        <div class="form-group">
            {!! Form::label('development_id', 'Development ID:')!!}
            {!! Form::number('development_id', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('plot_name', 'Plot Name:')!!}
            {!! Form::text('plot_name', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('house_type', 'House Type:')!!}
            {!! Form::number('house_type', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('sqft', 'SqFt:')!!}
            {!! Form::number('sqft', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('phase', 'Phase:')!!}
            {!! Form::number('phase', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Status:')!!}
            {!! Form::text('status', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Update Plot', ['class'=>'btn btn-primary col-sm-6']) !!}
        </div>
        {!! Form::close() !!}


        {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $plot->id]]) !!}
            <div class="form-group">
                {!! Form::submit('Delete Plot', ['class'=>'btn btn-danger col-sm-6']) !!}
            </div>
        {!! Form::close() !!}

    </div>
@endsection