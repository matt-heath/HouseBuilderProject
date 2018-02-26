@extends('layouts.admin')

@section('title')
    <h1>Create Development</h1>
@endsection

@section('content')

    <div id="smartwizard">
        <ul>
            <li><a href="#step-1">Create Development<br /><small>Input development details</small></a></li>
            <li><a href="#step-2">Add House Types<br /><small>Input house type details</small></a></li>
            {{--<li><a href="#step-3">Step Title<br /><small>Step description</small></a></li>--}}
            {{--<li><a href="#step-4">Step Title<br /><small>Step description</small></a></li>--}}
        </ul>

        <div>
            <div id="step-1" class="">
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
            </div>
            <div id="step-2" class="">


                    <div class="form-group">
                        {!! Form::submit('Create Development', ['class'=>'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            {{--<div id="step-3" class="">--}}
                {{--Step Content--}}
            {{--</div>--}}
            {{--<div id="step-4" class="">--}}
                {{--Step Content--}}
            {{--</div>--}}
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#smartwizard').smartWizard();
        });
    </script>
@endsection