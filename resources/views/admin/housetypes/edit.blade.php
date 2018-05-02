@extends('layouts.admin')

@section('title')
    <h1>Edit House Type</h1>
@endsection

@section('content')
    <div class="col-sm-6">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Example House Photo</th>
                <th>Floor Plan</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <a href="{{$houseTypes->house_img ? $houseTypes->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Example house image for: {{$houseTypes->house_type_name}} ">
                            <img src="{{$houseTypes->house_img ? $houseTypes->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td>
                        <a href="{{$houseTypes->floor_plan ? $houseTypes->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Floor plan image for: {{$houseTypes->house_type_name}}">
                            <img src="{{$houseTypes->floor_plan ? $houseTypes->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-sm-6">

            {!! Form::model($houseTypes, ['method'=>'PATCH', 'action'=> ['AdminHouseTypesController@update', $houseTypes->id], 'files' => true, 'data-toggle'=>'validator']) !!}
            <div class="form-group">
                {!! Form::label('development_id', 'Development Name:')!!}
                {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control select', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('house_type_name', 'House Type Name:')!!}
                {!! Form::text('house_type_name', null, ['class'=>'form-control','required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('house_type_desc', 'House Type Description:')!!}
                {!! Form::textarea('house_type_desc', null, ['class'=>'form-control', 'rows' => 5, 'cols' => 40, 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('flor_plan', 'Floor Plan Image:')!!}
                {!! Form::file('floor_plan', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('house_img', 'House Image:')!!}
                {!! Form::file('house_img', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update House Type', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}


            {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminHouseTypesController@destroy', $houseTypes->id], 'id' => 'confirm_delete_'.$houseTypes->id]) !!}
            <div class="form-group">
                {!! Form::submit('Delete House Type', ['class'=>'btn btn-danger col-sm-6', 'onclick'=>'confirmDelete(' .$houseTypes->id .')']) !!}
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
        $(document).ready(function() {
            $('.select').select2();
        });

        function confirmDelete(id) {
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
                swal({
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 3000
                }).then(function () {
                    $("#confirm_delete_"+id).off("submit").submit()
                })
                // $("#confirm_delete_"+id).off("submit").submit()
                // result.dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
            } else if (result.dismiss === 'cancel') {

            }
        })
        }
    </script>
@endsection