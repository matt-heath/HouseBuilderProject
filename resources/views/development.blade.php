@extends('layouts.development-single')



@section('content')



    <h1><address>{{$development->development_name.", ". $development->development_location}}</address></h1>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$development->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive img-rounded" src="{{$development->photo->file}}" alt="">

    <hr>

    <!-- Post Content -->
    <p class="lead">{{$development->development_description}}</p>

    <hr>

    <!-- Blog Comments -->


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
                </tr>
                </thead>
                <tbody>
                @foreach($plots as $plot)
                    <tr>

                        <td>{{$plot->development ? $plot->development->development_name : "Development Not Set" }}</td>
                        <td><a href="{{route('admin.plots.edit', $plot->id)}}">{{$plot->plot_name}}</a></td>
                        <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                        <td>{{$plot->sqft}}</td>
                        <td>{{$plot->phase}}</td>
                        <td>{{$plot->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection