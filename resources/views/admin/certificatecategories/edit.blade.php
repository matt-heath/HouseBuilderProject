@extends('layouts.admin')

@section('content')

    <h1>Edit Certificate Category</h1>

    <div class="row">
        <div class="col-sm-12">

            {!! Form::model($category, ['method'=>'PATCH', 'action'=> ['AdminCertificateCategoriesController@update', $category->id]]) !!}
            <div class="form-group">
                {!! Form::label('name', 'Category Name:')!!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('category_description', 'Category Description:')!!}
                {!! Form::text('category_description', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update category', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}


            {{--{!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $plot->id]]) !!}--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::submit('Delete Plot', ['class'=>'btn btn-danger col-sm-6']) !!}--}}
            {{--</div>--}}
            {{--{!! Form::close() !!}--}}

        </div>
    </div>

    <div class="row">
        @include('includes.form_error')
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.selectPlot').select2();
        });
    </script>
@endsection