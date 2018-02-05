@extends('layouts.admin')

@section('content')

    <h1>All Bookings</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->count())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-sm-12">
        <div class="table-responsive">
            @if($bookings)
                <table class="table table-striped table-bordered table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Buyers Name</th>
                        <th>Plot</th>
                        <th>Development</th>
                        <th>Status</th>
                        <th>Correspondence Address</th>
                        <th>Telephone Number</th>
                        <th>Email Address</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{$booking->title ? $booking->title : "Title not specified."}}</td>
                            <td>{{$booking->user ? $booking->user['name'] : "USER NOT FOUND"}}</td>
                            <td>{{$booking->plot_id ? $booking->plot['plot_name'] : "Plot not set." }}</td>
                            <td>{{$booking->plot_id ? $booking->plot->development['development_name'] : "Development not set." }}</td>
                            <td>{{$booking->plot ? $booking->plot['status'] : "Status not set." }}</td>
                            <td>{{$booking->correspondence_address ? $booking->correspondence_address : "Address not set." }}</td>
                            <td><a href="tel:{{$booking->telephone_num}}">{{$booking->telephone_num ? $booking->telephone_num : "" }}</a></td>
                            <td><a href="mailto:{{$booking->user['email']}}">{{$booking->user['email'] ? $booking->user['email'] : "" }}</a></td>
                            {{--<td><a href="{{route('admin.booking.edit', $booking->id)}}" class="btn btn-primary">View Booking</a></td>--}}
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('admin.booking.show', $booking->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a href="{{route('admin.booking.edit', $booking->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                                </div>
                                <div class="btn-group">
                                    {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminBookingsController@destroy', $booking->id], 'id'=> 'confirm_delete_'.$booking->id]) !!}
                                    {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$booking->id .')']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 8 }
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
