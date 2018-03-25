@extends('layouts.admin')

@section('title')
    <h1>Edit Plot</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6">
            {{--{{$image->floor_plan}}--}}

            {{--<img src="{{$image->photo->file ? $image->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">}}--}}
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
                       <a href="{{$image->house_img ? $image->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Example house image for: {{$image->house_type_name}}">
                           <img src="{{$image->house_img ? $image->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                       </a>
                     </td>
                     <td><a href="{{$image->floor_plan ? $image->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Floor plan image for: {{$image->house_type_name}}">
                             <img src="{{$image->floor_plan ? $image->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">

                         </a>
                     </td>
                 </tr>
               </tbody>
             </table>

        </div>
        <div class="col-sm-6">

            {!! Form::model($plot, ['method'=>'PATCH', 'action'=> ['AdminPlotsController@update', $plot->id]]) !!}
            <div class="form-group">
                {!! Form::label('development_id', 'Development:')!!}
                {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control selectPlot select']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('plot_name', 'Plot Name:')!!}
                {!! Form::text('plot_name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('house_type', 'House Type:')!!}
                {!! Form::select('house_type', [''=>'Choose House Type'] + $houseType, null, ['class'=>'form-control selectPlot select']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('sqft', 'SqFt:')!!}
                {!! Form::number('sqft', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phase', 'Phase:')!!}
                {!! Form::number('phase', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Status:')!!}
                {!! Form::text('status_disabled', $plot->status, ['class'=>'form-control', 'disabled']) !!}
                {!! Form::text('status', null, ['class'=>'form-control hidden']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Update Plot', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}


            {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $plot->id], 'id' => 'confirm_delete_'.$plot->id]) !!}
            <div class="form-group">
                {!! Form::submit('Delete Plot', ['class'=>'btn btn-danger col-sm-6','onclick'=>'confirmDelete(' .$plot->id .')']) !!}
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