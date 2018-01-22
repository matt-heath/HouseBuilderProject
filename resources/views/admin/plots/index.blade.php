@extends('layouts.admin')

@section('content')

    <h1>Plots</h1>



    <div class="col-sm-3">

        {!! Form::open(['method'=>'POST', 'action'=>'AdminPlotsController@store'])!!}
            <div class="form-group">
                {!! Form::label('development_id', 'Development ID:')!!}
                {!! Form::number('development_id', null, ['class'=>'form-control']) !!}
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
                    <th>ID</th>
                    <th>Development ID</th>
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
                        <td>{{$plot->id}}</td>
                        <td>{{$plot->development_id}}</td>
                        <td>{{$plot->plot_name}}</td>
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
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]

            });
        });
    </script>

@endsection
