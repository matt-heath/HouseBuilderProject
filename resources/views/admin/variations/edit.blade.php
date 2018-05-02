@extends('layouts.admin')

@section('title')
    <h1>Edit Variation</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            {{--{{$image->floor_plan}}--}}

            {{--<img src="{{$image->photo->file ? $image->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">}}--}}
            <table class="table table-responsive">
               <thead>
                 <tr>
                  <th>Current Variation Photo</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>
                     <td>
                       <a href="{{$variation->extra_img ? $variation->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image">
                           <img src="{{$variation->extra_img ? $variation->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                       </a>
                     </td>
                 </tr>
               </tbody>
             </table>
        </div>
        {{--{{$default}}--}}
        <div class="col-sm-6">
            {!! Form::model($variation, ['method'=>'PATCH', 'action'=> ['VariationController@update', $variation->id], 'files'=> true, 'data-toggle'=>'validator']) !!}
            <div class="form-group">
                {!! Form::label('category_id', 'Variation Category:')!!}
                {!! Form::select('category_id', $categories->toArray(), $categories, ['class'=>'form-control', 'disabled']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('selection_type_id', 'Variation Type:')!!}
                {!! Form::text('selection_type_id_disabled', $default,['class'=>'form-control', 'id'=>'developments', 'style'=>'height: 34px !important', 'disabled']) !!}
                {!! Form::text('selection_type_id', $default,['class'=>'form-control hidden', 'id'=>'developments', 'style'=>'height: 34px !important']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('name', 'Variation Name:')!!}
                {!! Form::text('name', null, ['class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Variation Description:')!!}
                {!! Form::textarea('description', null, ['class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('price', 'Price:')!!}
                {!! Form::text('price', null, ['class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                {!! Form::label('extra_img', 'Variation Image:')!!}
                {!! Form::file('extra_img', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update Variation', ['class'=>'btn btn-primary col-sm-6']) !!}
                <br><br>
            </div>
            {!! Form::close() !!}
            {{--{!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $plot->id], 'id' => 'confirm_delete_'.$plot->id]) !!}--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::submit('Delete Plot', ['class'=>'btn btn-danger col-sm-6','onclick'=>'confirmDelete(' .$plot->id .')']) !!}--}}
            {{--</div>--}}
            {{--{!! Form::close() !!}--}}
        </div>
    </div>

    {{--<div class="row">--}}
        {{--@include('includes.form_error')--}}
    {{--</div>--}}

@endsection
@section('script')
    <script>
        $(document).ready(function(){
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
                    text: 'Plot has been deleted.',
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