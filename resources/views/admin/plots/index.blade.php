@extends('layouts.admin')

@section('title')
    <h1>Plots</h1>
@endsection

@section('content')
    <div class="col-sm-12">
        @if($plots)
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th>Development Name</th>
                    <th>Plot Name</th>
                    <th>House Type</th>
                    <th>SqFt</th>
                    <th>Phase</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($plots as $plot)
                    {{$plot->phases ? $plot->phases->plot_name : "NOT FOUND"}}
                    <tr>
                        <td><a href="{{route('admin.plotsbydevelopment', ['id'=>$plot->development_id])}}">{{$plot->development ? $plot->development->development_name : "Development Not Set"}}</a></td>
                        <td>{{$plot->plot_name}}</td>
                        <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                        <td>{{$plot->sqft}}</td>
                        <td>{{$plot->phases ? $plot->phases->phase_name : "NONE"}}</td>
                        <td>{{$plot->status}}</td>
                        <td>
                            @if(!$plot->certificates->isEmpty())
                                <div class="btn-group">
                                    <a href="{{route('admin.certificates.edit', $plot->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-certificate fa-sm"></i></a>
                                </div>
                            @endif
                            <div class="btn-group">
                                <a href="{{route('admin.plots.edit', $plot->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                            <div class="btn-group">
                                {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $plot->id], 'id'=> 'confirm_delete_'.$plot->id]) !!}
                                {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$plot->id .')']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 6 }
                ]

            });
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
