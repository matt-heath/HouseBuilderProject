@extends('layouts.admin')

@section('content')

    <h1>Plots Assigned To</h1>

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
                    <th>Build Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>


                {{--Declares the variable count as 0 without printing to the screen --}}
                {{--*/ $count = 0 /*--}}

                @foreach($plots as $plot)

                    @foreach($plot->certificates as $certificate)

                        {{--{{$certificate}}--}}

                        {{--*/ $status = $certificate->build_status /*--}}

                    @endforeach
                    {{--{{$certificate_id}}--}}
                    {{--@for($i = 0; $i < count($cert_ids); $i++)--}}
                        {{--{{$id = $cert_ids[$i]}}--}}
                    {{--@endfor--}}

                    <tr>
                        <td><a href="{{route('admin.plotsbydevelopment', ['id'=>$plot->development_id])}}">{{$plot->development ? $plot->development->development_name : "Development Not Set"}}</a></td>
                        <td>{{$plot->plot_name}}</td>
                        <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                        <td>{{$plot->sqft}}</td>
                        <td>{{$plot->phase}}</td>
                        {{--<td>{{$plot->id}}</td>--}}
                        <td>{!! $status === "Ready for inspection" ? "<a href='' data-toggle='modal' data-target='#myModal' id='modalClick' data-id='$plot->id'>$status</a>" : $status !!}</td>
                        <td>
                            @if($status === "Property being inspected")
                                <div class="btn-group">
                                    <a href="{{route('externalconsultant.certificates.edit', $cert_ids[$count])}}" class="btn btn-warning"><i class="fa fa-fw fa-certificate fa-sm"></i></a>
                                </div>
                            @endif
                            <div class="btn-group">
                                <a href="{{route('admin.plots.edit', $plot->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                        </td>
                    </tr>

                    {{--*/ $count++ /*--}}
                @endforeach
                </tbody>
            </table>

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
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ]
            });
        });

        // $('#myModal'.on('show', function (e) {
        //     var link = e.relatedTarget(),
        //         modal = $(this),
        //         id = link.data('id')
        // }));

        $('#modalClick').on('click', function () {

            // console.log($(this).data());

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
    </script>
@endsection
