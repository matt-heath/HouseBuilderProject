@extends('layouts.admin')

@section('content')


    <h1>{{$plots ? "Plots in ".$development_name : "Plots"}}</h1>


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
                    <th>Booking</th>
                </tr>
                </thead>
                <tbody>
                @foreach($plots as $plot)
                    <tr>
                        <td>{{$plot->development ? $plot->development->development_name : "Development Not Set" }}</td>
                        <td>{{$plot->plot_name}}</td>
                        <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                        <td>{{$plot->sqft}}</td>
                        <td>{{$plot->phase}}</td>
                        <td>{{$plot->status}}</td>
                        @if($plot->status == 'Sold' || $plot->status == 'Reserved')
                            <td><a href="" class="btn btn-danger" disabled="disabled">Not Available</a> </td>
                        @else
                            <td><a href="{{route('booking.create', $plot->id)}}" class="btn btn-primary" >Book Property Here</a> </td>
                        @endif
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
                responsive: true
            });
        });
    </script>

@endsection
