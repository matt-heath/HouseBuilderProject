@extends('layouts.admin')

@section('title')
    <h1>Assign Consultant to Plots</h1>
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
    {{-- Wizard found and adapted from https://bootsnipp.com/snippets/featured/form-wizard-using-tabs --}}
    <div class="row">
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="fa fa-home"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="fa fa-building"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="fa fa-map-marker"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            {!! Form::open(['method'=>'POST', 'action'=>'AdminCertificatesController@store', 'files' => true])!!}

            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="step1">
                        <div class="row">

                            <div class="form-group">
                                {!! Form::label('development_id', 'Development Name:')!!}
                                {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control selectPlot developmentSelect']) !!}
                            </div>

                            <div class="form-group hidden" id="typeSelect">
                                {!! Form::label('house_type', 'House Type:')!!}
                                {!! Form::select('house_type', [''=>'Choose House Type'], null, ['class'=>'form-control selectPlot houseTypeSelect']) !!}
                            </div>

                            <div class="form-group hidden" id="phaseSelect">
                                {!! Form::label('phase', 'Development Phase:')!!}
                                {!! Form::select('phase', [''=>'Choose Phase Number'], null, ['class'=>'form-control selectPlot phaseSelect']) !!}
                            </div>

                            {{--<div class="form-group">--}}
                            {{--{!! Form::label('certificate_check', 'Certificate checked?')!!}--}}
                            {{--{!! Form::text('certificate_check_disabled', 'False', ['class'=>'form-control', 'disabled']) !!}--}}
                            {{--{!! Form::text('certificate_check', 'False', ['class'=>'form-control hidden']) !!}--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                    </ul>
                </div>

                <div class="tab-pane" role="tabpanel" id="step2">
                    <div class="step2">
                        <div class="step_21">
                            <div class="row">
                                <table id="myTable" width="100%" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Consultant Description</th>
                                        <th>Select a consultant</th>
                                        {{--<th>Add new consultant to dropdown</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($count = 0)
                                    @foreach($certificates as $certificate)
                                        <tr>
                                            <td>
                                                {!! Form::text('certificate_name_disabled', null, ['class'=>'form-control name_list', 'name'=>'certificate_name[]', 'placeholder' =>  $certificate->certificate_name,'disabled']) !!}
                                                {!! Form::text('certificate_name', $certificate->id, ['class'=>'form-control name_list hidden', 'name'=>'certificate_name[]']) !!}

                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    {!! Form::select('consultant_id', ['' => 'Select Consultant Responsible'] + $consultants, null, ['class'=>'form-control consultantSelect select', 'name' => 'consultant_id[]'])!!}
                                                </div>
                                                <div class="form-group" id="consultantDetails">

                                                </div>
                                            </td>
                                        </tr>
                                        @php ($count++)
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                        <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                    </ul>
                </div>
                <div class="tab-pane" role="tabpanel" id="step3">
                    <div class="step33">
                        <h5><strong>Plot Details</strong></h5>
                        <hr>
                        <div class="row">

                            <div class="form-group hidden" id="plotSelect">

                            </div>


                            <div class="form-group">
                                {!! Form::submit('Upload Certificate', ['class'=>'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            // e.preventDefault();
            $('.consultantSelect').select2();
            $('.selectPlot').select2();
            $('.selectMultiple').select2();

            $('.nav-tabs > li a[title]').tooltip();

            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                var $target = $(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
            });
            $(".prev-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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

            $(document).on('change', '.houseTypeSelect', function(){
                // console.log("Changed");

                var house_type_id=$(this).val();
                console.log(house_type_id);
                var option = "";

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('findPhases') !!}',
                    data: {'id': house_type_id},
                    success: function (data) {
                        console.log('Success!!');
                        console.log(data);
                        console.log('Phase' + data.length);
                        if(data.length != 0){
                            $(".phaseSelect").prop("disabled", false);
                            option +='<option value="" selected disabled>Choose Development Phase</option>';
                        }else{
                            $(".phaseSelect").prop("disabled", true);
                            option +='<option value="" selected disabled>No Phases available - Create plots associated to one!</option>';
                        }

                        // console.log("DATA PHASE"+data.phase);

                        for(var i = 0; i < data.length; i++){
                            option+='<option value="'+data[i].phase+'">'+data[i].phase+'</option>';
                            console.log(option);
                        }


                        $(".phaseSelect").html(" ").append(option);
                        $("#phaseSelect").removeClass("hidden");

                        // console.log(option);

                    },
                    error: function () {
                        console.log("Failed...")
                    }
                })
            });

            $(document).on('change', '.phaseSelect', function(){
                console.log("Changed");

                var phase_id=$(this).val();
                console.log(phase_id);
                var option = "";

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('findPlots') !!}',
                    data: {'id': phase_id},
                    success: function (data) {
                        console.log('Success!!');
                        console.log(data);
                        console.log(data.length);
                        if(data.length == 0){
                            $(".plotSelect").prop("disabled", false);
                            option += '{!! Form::label('selected_plots', 'Number of plots to assign to:')!!}';
                            option +='{!! Form::number('selected_plots', null, ['class'=>'form-control plotSelect', 'placeholder'=>'No plots available to assign to']) !!}';

                        }else{
                            $(".plotSelect").prop("disabled", true);
                            option += '{!! Form::label('selected_plots', 'Number of plots to assign to:')!!}';
                            option += '{!! Form::number('selected_plots', null, ['class'=>'form-control plotSelect']) !!}';
                        }

                        // for(var i = 0; i < data.length; i++){
                        //     option+='<option value="'+data[i].plot_name_id+'">'+data[i].plot_name_id+'</option>';
                        // }


                        $("#plotSelect").html(" ").append(option);
                        $("#plotSelect").removeClass("hidden");

                        // console.log(option);

                    },
                    error: function () {
                        console.log("Failed...")
                    }
                })
            });

        });
    </script>

@endsection
