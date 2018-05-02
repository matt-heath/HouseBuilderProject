@extends('layouts.admin')

@section('title')
    <h1>Create Plots</h1>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminPlotsController@store', 'data-toggle'=>'validator'])!!}
        <div id="smartwizard">
            <ul>
                <li><a href="#step-1">Select Development<br/>
                        <small>Choose a development</small>
                    </a></li>
                <li><a href="#step-2">Select House Type and Phase Details<br/>
                        <small>Choose a house type & phase</small>
                    </a></li>
                <li><a href="#step-3">Number of Plots to Generate<br/>
                        <small>Input number of plots</small>
                    </a></li>
            </ul>
            <div>
                <div id="step-1" class="">
                    <h2>Development Details</h2>
                    <div id="form-step-0" role="form" data-toggle="validator">
                        <div class="form-group">
                            {!! Form::label('development_id', 'Development Name:')!!}
                            {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control selectPlot developmentSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div id="step-2" class="">
                    <h2>House Type & Phase Details</h2>
                    <div id="form-step-1" role="form" data-toggle="validator">
                        <div class="form-group">
                            {!! Form::label('house_type', 'House Type:')!!}
                            {!! Form::select('house_type', [''=>'Choose House Type'], null, ['class'=>'form-control selectPlot houseTypeSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>

                        {{-- TODO: Add number of phases to migration? --}}
                        <div class="form-group">
                            {!! Form::label('phase', 'Phase:')!!}
                            {!! Form::select('phase', [''=>'Choose Development Phase'], null, ['class'=>'form-control phaseSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('sqft', 'SqFt:') !!}
                            {!! Form::number('sqft', null, ['data-error' => "Please input a SqFt for the plots", 'class'=>'form-control name_list', 'placeholder' => 'SqFt', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Status:') !!}
                            {!! Form::text('status_disabled', 'For Sale', ['class'=>'form-control name_list', 'placeholder' => 'Status', 'disabled']) !!}
                            {!! Form::text('status', 'For Sale', ['class'=>'form-control name_list hidden', 'placeholder' => 'Status']) !!}
                        </div>
                    </div>
                </div>
                <div id="step-3" class="">
                    <h2>Number of Plots to Generate</h2>
                    <div id="form-step-2" role="form" data-toggle="validator">
                        <div class="form-group">
                            {!! Form::label('num_of_plots', 'Number of plots to generate:') !!}
                            {!! Form::number('num_of_plots', null, ['data-error' => "Please input number of plots to generate",'class' => 'form-control', 'placeholder' => 'Number of plots to generate', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    {!! Form::submit('Create Plots', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
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

            $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                // Enable finish button only on last step
                if (stepNumber == 3) {
                    $('.btn-finish').removeClass('disabled');
                } else {
                    $('.btn-finish').addClass('disabled');
                }
            });
            $('.select').select2();
            $('.selectPlot').select2();
            $('.phaseSelect').select2();

            //Initialize tooltips
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
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        var i = 1;

        {{--$('#add').click(function(){--}}
        {{--i++;--}}
        {{--$('#dynamic_field').append('' +--}}
        {{--'<tr id="row'+i+'" class="dynamic-added">' +--}}
        {{--'   <td>{!! Form::text('plot_name', null, ['class'=>'form-control name_list', 'name'=>'plot_name[]', 'placeholder' => 'Plot name']) !!}</td>' +--}}
        {{--'   <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'--}}
        {{--);--}}
        {{--});--}}

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
        $(document).on('change', '.developmentSelect', function () {
            // console.log("Changed");

            var dev_id = $(this).val();
            // console.log(dev_id);
            var option = "";
            var phase_option = "";

            $.ajax({
                type: 'get',
                url: '{!! URL::to('findHouseTypes') !!}',
                data: {'id': dev_id},
                success: function (data) {
                    console.log('Success!!');
                    console.log(data);
                    console.log(data.length);
                    if (data.length != 0) {
                        option += '<option value="" selected disabled>Choose House Type</option>';
                    } else {
                        option += '<option value="" selected disabled>No House types available - Create one!</option>';
                    }
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value="' + data[i].id + '">' + data[i].house_type_name + '</option>';
                    }
                    $(".houseTypeSelect").html(" ").append(option);
                },
                error: function () {
                    console.log("Failed...")
                }
            });

            $.ajax({
                type: 'get',
                url: '{!! URL::to('developmentPhases') !!}',
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

                    console.log(phase_option);

                },
                error: function () {
                    console.log("Failed...")
                }
            })
        });
    </script>
@endsection
