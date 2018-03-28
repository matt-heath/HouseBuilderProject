@extends('layouts.admin')

@section('title')
    <h1>Create Variations for {{$supplier->supplier_company_name}}</h1>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'VariationController@store', 'files' => true])!!}

        <div class="form-group">
            {!! Form::label('category_id', 'Development Name:')!!}
            {!! Form::select('category_id_disabled', $categories, 'default', ['class'=>'form-control', 'style'=>'height: 34px !important', 'disabled']) !!}
            {!! Form::select('category_id', $categories, 'default', ['class'=>'form-control hidden']) !!}
        </div>
        <div class="form-group">
            {{--{{ $selectionTypes }}--}}
            {!! Form::label('selection_type_id', 'Selection Type:')!!}
            {!! Form::select('selection_type_id', [''=>'Choose Type'] + $selectionTypes->toArray(), 'default', ['class'=>'form-control', 'id'=>'developments', 'style'=>'height: 34px !important']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('name', 'Variation Name:')!!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Variation Description:')!!}
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('price', 'Price:')!!}
            {!! Form::text('price', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('extra_img', 'Variation Image:')!!}
            {!! Form::file('extra_img', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::text('supplier_id', $supplier->id, ['class'=>'form-control hidden']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create Variation', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#developments').select2();
        });
    </script>

@endsection