@extends('layouts.admin')

@section('title')
    <h1>Edit Development</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image-1" data-title="Example development image for: {{$development->development_name}}">
                <img src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }}"  class="img-responsive img-rounded" alt="">
            </a>
        </div>
        <div class="col-sm-6">

            {!! Form::model($development, ['method'=>'PATCH', 'action'=>['AdminDevelopmentsController@update', $development->id], 'files' => true, 'data-toggle'=>'validator'])!!}

            <div class="form-group">
                {!! Form::label('development_name', 'Development Name:')!!}
                {!! Form::text('development_name', null, ['class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('development_location', 'Development Location:')!!}
                {!! Form::text('development_location', null, ['class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('development_description', 'Development Description:')!!}
                {!! Form::textarea('development_description', null, ['class'=>'form-control','rows' => 3, 'cols' => 40, 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('estate_agent_responsible', 'Estate Agent Responsible:')!!}
                {!! Form::select('estate_agent_responsible', $default ? $default + $estate_select : ['' => 'Select Estate Agent Responsible'] + $estate_select, null, ['class'=>'form-control consultantSelect select', 'required'])!!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('photo_id', 'Example Development Photo:')!!}
                {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update Development', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}

            {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminDevelopmentsController@destroy', $development->id], 'id'=> 'confirm_delete_'.$development->id]) !!}

            <div class="form-group">
                {!! Form::submit('Delete Development', ['class'=>'btn btn-danger col-sm-6', 'onclick'=>'confirmDelete(' .$development->id .')']) !!}
            </div>
            {!! Form::close() !!}
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