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

        {{--<table id="myTable" width="100%" class="table table-striped table-bordered table-hover">--}}
            {{--<thead>--}}
            {{--<tr>--}}
                {{--<th>Title</th>--}}
                {{--<th>Buyers Name</th>--}}
                {{--<th>Plot</th>--}}
                {{--<th>Development</th>--}}
                {{--<th>Status</th>--}}
                {{--<th>Correspondence Address</th>--}}
                {{--<th>Telephone Number</th>--}}
                {{--<th>Email Address</th>--}}
                {{--<th>View Booking</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@if($bookings)--}}
                {{--@foreach($bookings as $booking)--}}
                    {{--<tr>--}}
                        {{--<td>{{$booking->title ? $booking->title : "Title not specified."}}</td>--}}
                        {{--<td>{{$booking->user ? $booking->user['name'] : "USER NOT FOUND"}}</td>--}}
                        {{--<td>{{$booking->plot_id ? $booking->plot['plot_name'] : "Plot not set." }}</td>--}}
                        {{--<td>{{$booking->plot_id ? $booking->plot->development['development_name'] : "Development not set." }}</td>--}}
                        {{--<td>{{$booking->plot ? $booking->plot['status'] : "Status not set." }}</td>--}}
                        {{--<td>{{$booking->correspondence_address ? $booking->correspondence_address : "Address not set." }}</td>--}}
                        {{--<td><a href="tel:{{$booking->telephone_num}}">{{$booking->telephone_num ? $booking->telephone_num : "" }}</a></td>--}}
                        {{--<td><a href="mailto:{{$booking->user['email']}}">{{$booking->user['email'] ? $booking->user['email'] : "" }}</a></td>--}}
                        {{--<td><a href="{{route('estateagent.booking.edit', $booking->id)}}" class="btn btn-primary">View Booking</a></td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
            {{--@endif--}}
            {{--</tbody>--}}
        {{--</table>--}}

    <table id="myTable" width="100%" class="table table-striped table-bordered table-hover table-responsive">
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
            <th>View Booking</th>
        </tr>
        </thead>
        <tbody>

        @if($bookings)
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
                    <td><a href="{{route('estateagent.booking.edit', $booking->id)}}" class="btn btn-primary">View Booking</a></td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true

            });
        });
    </script>

@endsection
