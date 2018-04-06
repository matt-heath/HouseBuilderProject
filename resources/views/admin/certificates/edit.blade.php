@extends('layouts.admin')

@section('title')
    <h1>Edit Certificate Status for Plot</h1>
@endsection


@section('content')
    <div class="row">
        {{--<div class="col-sm-6">--}}


                {{--{{$plot}}--}}
                {{--<table id="myTable" width="100%" class="table table-striped table-bordered table-hover">--}}
                   {{--<thead>--}}
                     {{--<tr>--}}
                         {{----}}
                     {{--</tr>--}}
                   {{--</thead>--}}
                   {{--<tbody>--}}
                   {{--@foreach($plots as $plot)--}}
                       {{--{{$plot}}--}}
                     {{--<tr>--}}
                         {{--<td>{{$plot->plot_name}}</td>--}}
                         {{--<td>{{$plot->houseTypes->house_type_name}}</td>--}}
                     {{--</tr>--}}
                   {{--@endforeach--}}
                   {{--</tbody>--}}
                {{--</table>--}}
        {{--</div>--}}

        <div class="col-sm-12">
            <table id="myTable1" width="100%" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Plot Name</th>
                    <th>House Type</th>
                    <th>Certificate Name</th>
                    <th>Build Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($certificates as $certificate)
                    {{--{{$certificate}}--}}
                    <tr>
                        @foreach($plots as $plot)
                            <td>{{$plot->plot_name}}</td>
                            <td>{{$plot->houseTypes->house_type_name}}</td>
                        @endforeach
                        <td>{{$certificate->certificatesRequired[0]->certificate_name}}</td>
                        <td>{{$certificate->build_status}}</td>
                        <td>{!! $certificate->build_status === "Not ready" ? "<a href='' data-toggle='modal' data-target='#myModal' id='modalClick' data-id='$certificate->id'>Update Status</a>" : $certificate->build_status !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Property ready to be inspected?</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::model($certificate, ['method'=>'PATCH', 'class'=> 'modalPlot', 'action'=>['AdminCertificatesController@update', $certificate->id]])!!}

                        <div class="form-group">
                            {{ Form::label('status', 'Can the consultant inspect this aspect of the property?') }}
                            <div class="form-inline">
                                <div class="radio">
                                    {{ Form::radio('status', 'yes') }}
                                    {{ Form::label('yes', 'Yes') }}
                                </div>
                                <div class="radio">
                                    {{ Form::radio('status', 'no', true) }}
                                    {{ Form::label('no', 'No') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            {!! Form::submit('Update status', ['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable1').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": [0,1,4] }
                ]
            });
        });

        // $('#myModal'.on('show', function (e) {
        //     var link = e.relatedTarget(),
        //         modal = $(this),
        //         id = link.data('id')
        // }));

        $('#modalClick').on('click', function () {

            console.log("DATA: " + $(this).data('id'));

            $('.modalPlot').attr('action', '/admin/certificates/'+$(this).data('id'));
        });

    </script>

@endsection