@extends('layouts.admin')

@section('title')
    <h1>Booking Information</h1>
@endsection

@section('content')
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

    {{--{{count($consultant_names)}}--}}
    <div class="row">
            <div class="col-sm-6">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>House Type Photo</th>
                        <th>Floor Plan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="{{$booking->plot->houseTypes->house_img ? $booking->plot->houseTypes->house_photo->file : 'http://placehold.it/400x400'}}" data-lightbox="image" data-title="Example house image for: {{$booking->plot->houseTypes->house_type_name}}">
                                <img src="{{$booking->plot->houseTypes->house_img ? $booking->plot->houseTypes->house_photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive img-rounded">
                            </a>
                        </td>
                        <td>
                            <a href="{{$booking->plot->houseTypes->floor_plan ? $booking->plot->houseTypes->photo->file : 'http://placehold.it/400x400'}}" data-lightbox="image" data-title="Floor plan image for: {{$booking->plot->houseTypes->house_type_name}}">
                                <img src="{{$booking->plot->houseTypes->floor_plan ? $booking->plot->houseTypes->photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive img-rounded">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">

                <div id="exTab2">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a  href="#1" data-toggle="tab">Request Certificates</a>
                        </li>
                        <li><a href="#2" data-toggle="tab">...</a>
                        </li>
                        <li><a href="#3" data-toggle="tab">...</a>
                        </li>
                    </ul>

                    <div class="tab-content ">
                        <div class="tab-pane active" id="1">
                            {!! Form::open(['method'=>'POST', 'action'=>'AdminCertificatesController@store', 'files' => true])!!}

                                <div class="form-group">
                                    {!! Form::label('certificate_name', 'Certificate Name:')!!}
                                    {!! Form::text('certificate_name', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('certificate_check', 'Certificate checked?')!!}
                                    {!! Form::text('certificate_check_disabled', 'False', ['class'=>'form-control', 'disabled']) !!}
                                    {!! Form::text('certificate_check', 'False', ['class'=>'form-control hidden']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('certificate_category_id', 'Certificate:')!!}
                                    {!! Form::select('certificate_category_id', [''=>'Choose Certificate'] + $certificates, 'default', ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        {!! Form::label('certificate_doc', 'Certificate/doc:')!!}
                                        {!! Form::file('certificate_doc', null, ['class'=>'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('consultant_id', 'Certificate:')!!}
                                    {!! Form::select('consultant_id', [''=>'Choose Consultant Responsible'] + $options,  null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::submit('Create House Type', ['class'=>'btn btn-primary']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane" id="2">

                        </div>
                        <div class="tab-pane" id="3">

                        </div>
                    </div>
                </div>

                <hr>
            </div>
        </div>
    <div class="col-sm-12">
        <div class="table-responsive">
            @if($booking)
                <table class="table table-striped table-bordered table-hover">
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
                                {{--<div class="btn-group">--}}
                                    {{--<a href="{{route('admin.booking.show', $booking->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>--}}
                                {{--</div>--}}
                                <div class="btn-group">
                                    <a href="{{route('admin.booking.edit', $booking->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                                </div>
                                {{--<div class="btn-group">--}}
                                    {{--{!! Form::open(['method'=>'DELETE', 'action'=> ['AdminBookingsController@destroy', $booking->id], 'id'=> 'confirm_delete_'.$booking->id]) !!}--}}
                                    {{--{!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$booking->id .')']) !!}--}}
                                    {{--{!! Form::close() !!}--}}
                                {{--</div>--}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection

@section('script')

    <script>

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
                    text: 'Booking has been deleted.',
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
