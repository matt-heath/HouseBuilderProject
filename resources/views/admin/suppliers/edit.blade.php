@extends('layouts.admin')

@section('title')
    <h1>Edit Supplier Details</h1>
@endsection

@section('content')
    <div class="row">
        {{--TODO: ADD photo_id to suppliers table?--}}
        <div class="col-sm-6">
            <a href="{{'http://placehold.it/400x400' }} " data-lightbox="image-1" data-title="Example development image for: ">
                <img src="{{'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
            </a>
        </div>
        <div class="col-sm-6">

            {!! Form::model($supplier, ['method'=>'PATCH', 'action'=>['SupplierController@update', $supplier->id], 'files' => true])!!}
            <div class="form-group">
                {!! Form::label('supplier_company_name', 'Supplier Company Name:')!!}
                {!! Form::text('supplier_company_name', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('supplier_type', 'Supplier Type:')!!}
                {!! Form::select('supplier_type', $default->toArray() + $selectionCategories->toArray(), null, ['class'=>'form-control dynamicSelect']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update Supplier', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}

{{--            {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminDevelopmentsController@destroy', $development->id], 'id'=> 'confirm_delete_'.$development->id]) !!}--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::submit('Delete Development', ['class'=>'btn btn-danger col-sm-6', 'onclick'=>'confirmDelete(' .$development->id .')']) !!}--}}
            {{--</div>--}}
{{--            {!! Form::close() !!}--}}
        </div>
    </div>

    {{--<div class="row">--}}
        {{--@include('includes.form_error')--}}
    {{--</div>--}}

@endsection

@section('script')

    <script>
        function confirmDelete(id) {
        console.log(id);
        event.preventDefault();

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            buttonsStyling: true
        }).then((result) => {
        if (result.value) {
            swal(
            'Deleted!',
            'Development has been deleted.',
            'success'
            )
            $("#confirm_delete_"+id).off("submit").submit()
            // result.dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
        } else if (result.dismiss === 'cancel') {

        }
        })
        }
    </script>
@endsection