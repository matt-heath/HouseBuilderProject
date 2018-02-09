@extends('layouts.admin')

@section('content')

    <h1>Plots</h1>

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
                        <td>{{$plot->development ? $plot->development->development_name : "Development Not Set"}}</td>
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

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>

@endsection
