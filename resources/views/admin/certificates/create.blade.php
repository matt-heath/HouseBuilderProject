@extends('layouts.admin')


@section('title')
    <h1>Create Required Certificates</h1>
@endsection

@section('content')

    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminCertificatesController@createCertificate', 'files' => true])!!}

        <div class="form-group">
            {!! Form::label('certificate_name', 'Certificate Name:')!!}
            {!! Form::text('certificate_name', null, ['class'=>'form-control']) !!}
        </div>

        {{--<div class="form-group">--}}
            {{--{!! Form::label('certificate_check', 'Certificate checked?')!!}--}}
            {{--{!! Form::text('certificate_check', 'False', ['class'=>'form-control', 'disabled']) !!}--}}
        {{--</div>--}}
        <div class="form-group">
            {!! Form::label('certificate_category_id', 'Certificate:')!!}
            {!! Form::select('certificate_category_id', [''=>'Choose Certificate'] + $certificates, 'default', ['class'=>'form-control select']) !!}
        </div>

        {{--<div class="form-group">--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('certificate_doc', 'Certificate/doc:')!!}--}}
                {{--{!! Form::file('certificate_doc', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="form-group">
            {!! Form::submit('Create Certificate', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@section('script')
    <script>
        $('.select').select2();
    </script>
@endsection