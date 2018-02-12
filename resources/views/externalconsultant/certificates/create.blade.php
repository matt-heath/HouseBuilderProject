@extends('layouts.admin')

@section('content')

    <h1>Create/Upload Certificates</h1>

    {{--<div class="row">--}}
        {{--{!! Form::open(['method'=>'POST', 'action'=>'AdminCertificatesController@store', 'files' => true])!!}--}}

        {{--<div class="form-group">--}}
            {{--{!! Form::label('certificate_name', 'Certificate Name:')!!}--}}
            {{--{!! Form::text('certificate_name', null, ['class'=>'form-control']) !!}--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--{!! Form::label('certificate_check', 'Certificate checked?')!!}--}}
            {{--{!! Form::text('certificate_check', 'False', ['class'=>'form-control', 'disabled']) !!}--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--{!! Form::label('certificate_category_id', 'Certificate:')!!}--}}
            {{--{!! Form::select('certificate_category_id', [''=>'Choose Certificate'] + $certificates, 'default', ['class'=>'form-control']) !!}--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('certificate_doc', 'Certificate/doc:')!!}--}}
                {{--{!! Form::file('certificate_doc', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--{!! Form::submit('Create House Type', ['class'=>'btn btn-primary']) !!}--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}
    {{--</div>--}}

@endsection