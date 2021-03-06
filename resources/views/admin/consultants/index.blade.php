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
    <div class="row">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Consultant Account</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact', 'data-toggle'=>'validator'])!!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class'=>'form-control', 'required'])!!}
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', null, ['class'=>'form-control', 'required'])!!}
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('role_id', 'Role:') !!}
                            {!! Form::text('role_id_disabled', $roles, ['class'=>'form-control roleSelect select', 'disabled'])!!}
                            {!! Form::text('role_id', $roles, ['class'=>'form-control roleSelect select hidden'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('consultant_description', 'Consultant Description:') !!}
                            {!! Form::textarea('consultant_description', null, ['class'=>'form-control name_list', 'placeholder' => 'Consultant Description', 'rows' => 2, 'cols' => 40, 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="form-group">
                            {!! Form::label('is_active', 'Status:') !!}
                            {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 1 , ['class'=>'form-control', 'required'])!!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['data-minlength'=>'6','required','class'=>'form-control', 'placeholder'=>'Password'])!!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('inputPasswordConfirm', 'Confirm Password:') !!}
                            {!! Form::password('inputPasswordConfirm', ['data-match'=>'#password','data-match-error'=>"Whoops, these passwords don't match",'required','class'=>'form-control', 'placeholder'=>'Confirm Password'])!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addUser']) !!}
                        </div>
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminCertificatesController@store', 'files' => true, 'data-toggle'=>'validator'])!!}
        <div id="smartwizard">
            <ul>
                <li><a href="#step-1">Select Development<br/>
                        <small>Select development details</small>
                    </a></li>
                <li><a href="#step-2">Select consultants responsible for phase<br/>
                        <small>Assign consultants to certificate(s)</small>
                    </a></li>
                {{--<li><a href="#step-3">Add House Types<br /><small>Input house type details</small></a></li>--}}
            </ul>
            <div>
                <div id="step-1" class="">
                    <div id="form-step-0" role="form" data-toggle="validator">
                        <div class="form-group">
                            {!! Form::label('development_id', 'Development Name:')!!}
                            {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control selectPlot developmentSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        {{--<div class="form-group hidden" id="typeSelect">--}}
                        {{--{!! Form::label('house_type', 'House Type:')!!}--}}
                        {{--{!! Form::select('house_type', [''=>'Choose House Type'], null, ['class'=>'form-control selectPlot houseTypeSelect']) !!}--}}
                        {{--</div>--}}
                        <div class="form-group hidden" id="phaseSelect">
                            {!! Form::label('phase', 'Development Phase:')!!}
                            {!! Form::select('phase', [''=>'Choose Phase Number'], null, ['class'=>'form-control selectPlot phaseSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            {!! Form::text('certificate_check', 'False', ['class'=>'form-control hidden']) !!}
                        </div>
                    </div>
                </div>

                <div id="step-2" class="">
                    <div id="form-step-1" role="form" data-toggle="validator">
                        <div class="pull-right">
                            <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal'
                                    id='modalClick'><i class="fa fa-fw fa-plus"></i> Add consultant account
                            </button>
                        </div>
                        <br><br>
                        <table id="myTable" width="100%" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Consultant Description</th>
                                <th>Select a consultant</th>
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
                                            {!! Form::select('consultant_id', ['' => 'Select Consultant Responsible'] + $consultants, null, ['class'=>'form-control consultantSelect select', 'name' => 'consultant_id[]', 'required'])!!}
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group" id="consultantDetails">

                                        </div>
                                    </td>
                                </tr>
                                @php ($count++)
                            @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            {!! Form::submit('Add consultants to phase', ['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            // e.preventDefault();
            var btnCancel = $('<button></button>').text('Cancel')
                .addClass('btn btn-danger')
                .on('click', function () {
                    $('#smartwizard').smartWizard("reset");
                    $('#myForm').find("input, textarea").val("");
                });


            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                transitionEffect: 'fade',
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    toolbarExtraButtons: [btnCancel]
                },
                anchorSettings: {
                    markDoneStep: true, // add done css
                    markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                    enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                }
            });

            $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                console.log(elmForm);

                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward' && elmForm) {
                    elmForm.validator('validate');
                    var elmErr = elmForm.find('.has-danger');
                    console.log('ELM ERR: ' + elmErr + 'LENGTH: ' + elmErr.length);
                    if (elmErr && elmErr.length > 0) {
                        // Form validation failed
                        console.log("FALSE");
                        return false;
                    }
                }
                return true;
            });
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
            $(document).on('change', '.developmentSelect', function () {
                // console.log("Changed");

                var dev_id = $(this).val();
                console.log(dev_id);
                // var option = "";
                var phase_option = "";

                {{--$.ajax({--}}
                {{--type: 'get',--}}
                {{--url: '{!! URL::to('getHouseTypes') !!}',--}}
                {{--data: {'id': dev_id},--}}
                {{--success: function (data) {--}}
                {{--console.log('Success!!');--}}
                {{--console.log(data);--}}
                {{--console.log(data.length);--}}
                {{--if(data.length != 0){--}}
                {{--$(".houseTypeSelect").prop("disabled", false);--}}
                {{--option +='<option value="" selected disabled>Choose House Type</option>';--}}
                {{--}else{--}}
                {{--$(".houseTypeSelect").prop("disabled", true);--}}
                {{--option +='<option value="" selected disabled>No House types available - Create one!</option>';--}}
                {{--}--}}

                {{--for(var i = 0; i < data.length; i++){--}}
                {{--option+='<option value="'+data[i].id+'">'+data[i].house_type_name+'</option>';--}}
                {{--}--}}


                {{--$(".houseTypeSelect").html(" ").append(option);--}}
                {{--$("#typeSelect").removeClass("hidden");--}}

                {{--// console.log(option);--}}

                {{--},--}}
                {{--error: function () {--}}
                {{--console.log("Failed...")--}}
                {{--}--}}
                {{--});--}}
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('getPhases') !!}',
                    data: {'id': dev_id},
                    success: function (phases) {
                        console.log('Success!!');
                        console.log(phases);
                        console.log(phases.length);
                        if (phases.length != 0) {
                            phase_option += '<option value="" selected disabled>Choose Development Phase</option>';
                        } else {
                            phase_option += '<option value="" selected disabled>No phases available - Create one!</option>';
                        }

                        for (var i = 0; i < phases.length; i++) {
                            phase_option += '<option value="' + phases[i].id + '">' + phases[i].phase_name + '</option>';
                        }


                        $(".phaseSelect").html(" ").append(phase_option);
                        $("#phaseSelect").removeClass("hidden");

                        console.log(phase_option);

                    },
                    error: function () {
                        console.log("Failed...")
                    }
                })
            });

            $(document).on('change', '.phaseSelect', function () {
                console.log("Changed");

                var phase_id = $(this).val();
                console.log(phase_id);
                var option = "";
                var dataObject = JSON.stringify({
                    'phase_id': $(this).val(),
                    'development_id': $('.developmentSelect').val(),
                });

                var development_id = $('.developmentSelect').val();

                // console.log(dataObject);

                {{--$.ajax({--}}
                {{--type: 'get',--}}
                {{--url: '{!! URL::to('findPlots') !!}',--}}
                {{--data: {'id': phase_id, 'dev_id': development_id },--}}
                {{--success: function (data) {--}}
                {{--console.log('Success!!');--}}
                {{--console.log(data);--}}
                {{--console.log(data.length);--}}
                {{--if(data.length == 0){--}}
                {{--$(".plotSelect").prop("disabled", false);--}}
                {{--option += '{!! Form::label('selected_plots', 'Number of plots to assign to:')!!}';--}}
                {{--option +='{!! Form::number('selected_plots', null, ['class'=>'form-control plotSelect', 'placeholder'=>'No plots available to assign to']) !!}';--}}

                {{--}else{--}}
                {{--$(".plotSelect").prop("disabled", true);--}}
                {{--option += '{!! Form::label('selected_plots', 'Number of plots to assign to:')!!}';--}}
                {{--option += '{!! Form::number('selected_plots', null, ['class'=>'form-control plotSelect']) !!}';--}}
                {{--}--}}

                {{--// for(var i = 0; i < data.length; i++){--}}
                {{--//     option+='<option value="'+data[i].plot_name_id+'">'+data[i].plot_name_id+'</option>';--}}
                {{--// }--}}


                {{--$("#plotSelect").html(" ").append(option);--}}
                {{--$("#plotSelect").removeClass("hidden");--}}

                {{--// console.log(option);--}}

                {{--},--}}
                {{--error: function () {--}}
                {{--console.log("Failed...")--}}
                {{--}--}}
                {{--})--}}
            });
            $('#addUser').on('click', function (e) {
                e.preventDefault();
                var data = $('form.contact').serialize();

                $.ajax({
                    type: "POST",
                    url: '/addUser',
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        console.log('USER ADDED' + data.id + data.name);
                        $('.consultantSelect').append('<option value="' + data.id + '">' + data.name + '(' + data.email + ') </option>');
                        $('#myModal').modal('hide');
                        $('#myModal form :input').val("");
                    },
                    error: function (data) {

                    }
                })
            });
        });
    </script>

@endsection
