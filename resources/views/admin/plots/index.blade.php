@extends('layouts.admin')

@section('content')

    <h1>Plots</h1>



    <div class="col-sm-3">

        {!! Form::open(['method'=>'POST', 'action'=>'AdminPlotsController@store'])!!}
            <div class="form-group">
                {!! Form::label('development_id', 'Development Name:')!!}
                {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('plot_name', 'Plot Name:')!!}
                {!! Form::text('plot_name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('house_type', 'House Type:')!!}
                {!! Form::number('house_type', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('sqft', 'SqFt:')!!}
                {!! Form::number('sqft', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phase', 'Phase:')!!}
                {!! Form::number('phase', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Status:')!!}
                {!! Form::text('status', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Create Plot', ['class'=>'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}


    </div>

    <div class="col-sm-9">
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
                        <td>{{$plot->house_type}}</td>
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
