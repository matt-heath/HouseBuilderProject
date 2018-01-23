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
            <th>Floor Plan Image</th>
            <th>House Image</th>
        </tr>
        </thead>
        <tbody>
        @if($houseTypes)

            {{--Declares the variable count as 0 without printing to the screen --}}
            {{--*/ $count = 0 /*--}}
            @foreach($houseTypes as $houseType)
                {{--{{ $houseType->photo}}--}}
                <tr>
                    {{--<td>{{$houseType}}</td>--}}

                    <td>{{$houseType->development_id ? $houseType->development->development_name : "Development Not Set" }}</td>
                    <td><a href="{{route('admin.housetypes.edit', $houseType->id)}}">{{$houseType->house_type_name}}</a></td>
                    <td>{{$houseType->house_type_desc}}</td>
                    {{--<td>{{$houseType->floor_plan}}</td>--}}
                    {{--<td>{{$houseType->house_img}}</td>--}}
                    <td><a href="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image-{{$count}}" data-title="Floor plan image for: {{$houseType->house_type_name}}">
                            <img src="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td><a href="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image-{{$count}}" data-title="Example house image for: {{$houseType->house_type_name}} ">
                            <img src="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    {{--<td><a href="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image-{{$count}}" data-title="Example development image for: ">--}}
                            {{--<img src="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">--}}
                        {{--</a>--}}
                    {{--</td>--}}
                    {{--<td>{{$development->created_at->diffForHumans()}}</td>--}}
                    {{--<td>{{$development->updated_at->diffForHumans()}}</td>--}}
                </tr>
                {{--*/ $count++ /*--}}

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
                    { "orderable": false, "targets": [3,4] }
                ]
            });
        });
    </script>

@endsection