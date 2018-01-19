@extends('layouts.admin')


@section('content')

    <h1>Edit Development</h1>






    <div class="row">
        <div class="col-sm-6">
            <a href="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image-1" data-title="Example development image for: {{$development->development_name}}">
                <img src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }}"  class="img-responsive img-rounded" alt="">
            </a>
        </div>
        <div class="col-sm-6">

            {!! Form::model($development, ['method'=>'PATCH', 'action'=>['AdminDevelopmentsController@update', $development->id], 'files' => true])!!}

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
                {!! Form::submit('Update Development', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}

            {!! Form::open(['method'=>'DELETE', 'action'=>['AdminDevelopmentsController@destroy', $development->id]])!!}

            <div class="form-group">
                {!! Form::submit('Delete Post', ['class'=>'btn btn-danger col-sm-6']) !!}
            </div>
            {!! Form::close() !!}
        </div>

    </div>

    <div class="row">
        @include('includes.form_error')
    </div>

@endsection