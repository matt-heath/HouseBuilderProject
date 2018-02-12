@extends('layouts.admin')

@section('content')

    <h1>Upload Certificate For Plot</h1>

    <div class="row">
        {!! Form::model($id, ['method'=>'PATCH', 'action'=>['ExternalConsultantCertificatesController@update', $id], 'files' => true])!!}

        {{--<div class="form-group">--}}
            {{--{!! Form::label('certificate_name', 'Certificate Description:')!!}--}}
            {{--{!! Form::text('certificate_name_disabled', null, ['class'=>'form-control']) !!}--}}
        {{--</div>--}}

        <div class="form-group">
            {!! Form::label('certificate_category_id', 'Certificate:')!!}
            {!! Form::select('certificate_category_id_disabled', $category, 'default', ['class'=>'form-control', 'disabled']) !!}
            {!! Form::select('certificate_category_id', $category, 'default', ['class'=>'form-control hidden']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('certificate_doc', 'Certificate/doc:')!!}
            {!! Form::file('certificate_doc', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create House Type', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    </div>

@endsection