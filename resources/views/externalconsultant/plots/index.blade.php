@extends('layouts.admin')

@section('title')
    <h1>Plots Assigned To</h1>
@endsection

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
    <div class="col-sm-12">
        @if($plots)
            <div class="table-responsive">
                <table class="table" id="myTable">
                    <thead>
                    <tr>
                        <th>Development Name</th>
                        <th>Plot Name</th>
                        <th>SqFt</th>
                        <th>Phase</th>
                        <th>Certificate Required</th>
                        <th>Build Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>


                    {{--Declares the variable count as 0 without printing to the screen --}}
                    @php($count = 0)
                    @foreach($plots as $plot)
                        @foreach($certificate_required_ids as $id)
                            <tr>
                                <td><a href="{{route('admin.plotsbydevelopment', ['id'=>$plot->development_id])}}">{{$plot->development ? $plot->development->development_name : "Development Not Set"}}</a></td>
                                <td>{{$plot->plot_name}}</td>
                                <td>{{$plot->sqft}}</td>
                                <td>{{$plot->phases->phase_name}}</td>

                                @foreach($plot->certificates as $cert)
                                    {{--{{$id}}--}}
                                    @if($cert->certificatesRequired->first()->id == $id)
                                        <td>{{$cert->certificatesRequired->first()->certificate_name}}</td>
                                    @elseif(!isset($cert->certificatesRequired->first()->certificate_name))
                                        <td></td>
                                    @endif
                                @endforeach

                                {{--<td>{{$plot->id}}</td>--}}
                                <td>{!! $status[$count] === "Ready for inspection" ? "<a href='' data-toggle='modal' data-target='#myModal' class='modalClick' id='modalClick' data-id='$certificate_ids[$count]'>$status[$count]</a>" : $status[$count] !!}</td>
                                <td>
                                    {{--{{$certificate_ids[$count]}}--}}
                                    @if($status[$count] === "Property being inspected")
                                        <div class="btn-group">
                                            <a href="{{route('externalconsultant.certificates.edit', $certificate_ids[$count])}}" class="btn btn-warning"><i class="fa fa-fw fa-certificate fa-sm"></i></a>
                                        </div>

                                    @elseif($status[$count] ==="Rejected")
                                        <div class="btn-group">
                                            <a href='' class="btn btn-danger rejectionClick" data-toggle='modal' data-target='#rejectionModal' id='rejectionClick' data-id={{$certificate_ids[$count]}}>Rejection Reasons</a>
                                        </div>

                                    @endif
                                </td>
                            </tr>
                            @php($count++)
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>


            <div class="modal fade" id="rejectionModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Rejection Reasons</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="certificate_check" value="3">
                            <div class="form-group">
                                {!! Form::label('rejection_reason', 'Certificate Rejection Notes:') !!}
                                {!! Form::textarea('rejection_reason', null, ['class'=>'form-control reject']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Inspecting Property?</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::model($plot, ['method'=>'PATCH', 'class'=> 'modalPlot', 'action'=>['ExternalConsultantPlotsController@update', $plot->id]])!!}

                                <div class="form-group">
                                    {{ Form::label('status', 'Are you ready to inspect the property?') }}
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
        @endif
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                // responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ]
            });
        });

        // $('#myModal'.on('show', function (e) {
        //     var link = e.relatedTarget(),
        //         modal = $(this),
        //         id = link.data('id')
        // }));

        $('.modalClick').on('click', function () {

            console.log($(this).data());

           $('.modalPlot').attr('action', '/externalconsultant/plots/'+$(this).data('id'));
        });

        //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
        $(document).on('change', '.developmentSelect', function(){
            // console.log("Changed");

            var dev_id=$(this).val();
            console.log(dev_id);
            var option = "";

            $.ajax({
                type: 'get',
                url: '{!! URL::to('findHouseTypes') !!}',
                data: {'id': dev_id},
                success: function (data) {
                    console.log('Success!!');
                    console.log(data);
                    console.log(data.length);
                    if(data.length != 0){
                        $(".houseTypeSelect").prop("disabled", false);
                        option +='<option value="" selected disabled>Choose House Type</option>';
                    }else{
                        $(".houseTypeSelect").prop("disabled", true);
                        option +='<option value="" selected disabled>No House types available - Create one!</option>';
                    }

                    for(var i = 0; i < data.length; i++){
                        option+='<option value="'+data[i].id+'">'+data[i].house_type_name+'</option>';
                    }


                    $(".houseTypeSelect").html(" ").append(option);
                    $("#typeSelect").removeClass("hidden");

                    // console.log(option);

                },
                error: function () {
                    console.log("Failed...")
                }
            })
        });

        $('.rejectionClick').on('click', function () {
            var cert_id=$(this).data('id');
            console.log(cert_id);

            $.ajax({
                type: 'get',
                url: '{!! URL::to('getRejectionReasons') !!}',
                data: {'id': cert_id},
                success: function (data) {
                    // console.log('Success!!');
                    console.log(data);
                    // console.log(data.length);
                    // console.log(data);
                    if(data.length != 0) {
                        console.log('Success!!');
                        var url = '{{ route("externalconsultant.certificates.edit", ":id") }}';

                        for(var i = 0; i < data.length; i++){
                            url = url.replace(':id', data[i].certificate_id);
                            console.log(data[i].rejection_reason);
                            $(".reject").html(" ").append(data[i].rejection_reason).attr('disabled', true);
                            $(".modal-footer").html(" ").append("<div class=\"btn-group\">\n" +
                                "                                <div class=\"btn-group\">\n" +
                                "                                    <a href="+url+" class=\"btn btn-warning\"><i class=\"fa fa-fw fa-certificate fa-sm\"></i> Re-upload Certificate</a>\n" +
                                "                                </div>\n" +
                                "                            </div>\n" +
                                "                            <div class=\"btn-group\">\n" +
                                "                                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n" +
                                "                            </div>")
                        }
                    }
                    // console.log(option);
                },
                error: function () {
                    console.log("Failed...")
                }
            })
        });
    </script>
@endsection
