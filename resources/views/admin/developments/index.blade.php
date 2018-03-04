@extends('layouts.admin')

@section('title')
    <h1>Developments</h1>
@endsection

@section('content')

    @if(Session::has('deleted_development'))
        <p class="bg-danger">{{session('deleted_development')}}</p>
    @endif

    <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
       <thead>
         <tr>
              <th>Development Name</th>
              <th>Development Location</th>
              <th>Number of plots</th>
              <th>Development Description</th>
              <th>Photo</th>
             <th></th>
         </tr>
       </thead>
        <tbody>

           @if($developments)
               {{--Declares the variable count as 0 without printing to the screen --}}
               @php ($count = 0)
               @foreach($developments as $development)
                     <tr>
                         <td>{{$development->development_name}}</td>
                         <td><a href="https://www.google.co.uk/maps/place/{{$development->development_location}}" target="_blank"><address>{{$development->development_location}}</address></a></td>
                         <td>{{$num_of_plots_available->where('development_id', $development->id)->count().'/'.$development->development_num_plots}}</td>
                         <td>{{$development->development_description}}</td>
                         <td>
                             <a href="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image-{{$count}}" data-title="Example development image for: {{$development->development_name}}">
                                 <img src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                             </a>
                         </td>
                         <td>
                             <div class="btn-group">
                                 <a href="{{route('home.development', $development->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>
                             </div>
                             <div class="btn-group">
                                 <a href="{{route('admin.developments.edit', $development->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                             </div>
                             <div class="btn-group">
                                 {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminDevelopmentsController@destroy', $development->id], 'id'=> 'confirm_delete_'.$development->id]) !!}
                                 {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$development->id .')']) !!}
                                 {!! Form::close() !!}
                             </div>
                         </td>

                     </tr>
                     @php ($count++)
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
                    { "orderable": false, "targets": [4,5] }
                ]

            });
        });

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