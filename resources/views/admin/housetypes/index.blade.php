@extends('layouts.admin')

@section('content')

    {{--@if(Session::has('deleted_development'))--}}
        {{--<p class="bg-danger">{{session('deleted_development')}}</p>--}}
    {{--@endif--}}

    <h1>House Types</h1>


    <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Development Name</th>
            <th>House Type Name</th>
            <th>House Type Description</th>
            <th>House Image</th>
            <th>Floor Plan Image</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if($houseTypes)

            {{--Declares the variable count as 0 without printing to the screen --}}
            @php($count = 0)
            @foreach($houseTypes as $houseType)
                {{--{{ $houseType->photo}}--}}
                {{--{{$houseType}}--}}
                <tr>
                    <td>
                        {{$houseType->development_id ? $houseType->development->development_name : "Development Not Set" }}
                    </td>
                    <td>
                        {{$houseType->house_type_name}}
                    </td>
                    <td>
                        {{$houseType->house_type_desc}}
                    </td>
                    <td>
                        <a href="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image-{{$count}}" data-title="Example house image for: {{$houseType->house_type_name}} ">
                            <img src="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td><a href="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image-{{$count}}" data-title="Floor plan image for: {{$houseType->house_type_name}}">
                            <img src="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td>
                        <div class="btn-group-vertical">
{{--                            <a href="{{route('admin.housetypes.edit', $houseType->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>--}}
                        </div>
                        <div class="btn-group-vertical">
                            {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminHouseTypesController@destroy', $houseType->id], 'id'=> 'confirm_delete_'.$houseType->id]) !!}
                                {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$houseType->id .')']) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
                @php($count++)

            @endforeach
        @endif
        </tbody>
    </table>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": [3,4,5] }
                ]
            });
        });

        function confirmDelete(id) {
            // console.log(id);
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
                    'Your file has been deleted.',
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