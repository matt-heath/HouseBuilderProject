@extends('layouts.admin')

@section('content')

    <h1>Create Plots</h1>
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

            {!! Form::open(['method'=>'POST', 'action'=>'AdminPlotsController@store'])!!}
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="step1">
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('development_id', 'Development Name:')!!}
                                {!! Form::select('development_id', [''=>'Choose Development'] + $developments, null, ['class'=>'form-control selectPlot developmentSelect']) !!}
                            </div>
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
                                <div class="form-group">
                                    {!! Form::label('house_type', 'House Type:')!!}
                                    {!! Form::select('house_type', [''=>'Choose House Type'], null, ['class'=>'form-control selectPlot houseTypeSelect']) !!}
                                    {{--<span>Product Name: </span>--}}
                                    {{--<select style="width: 200px" class="houseTypeSelect">--}}

                                        {{--<option value="0" disabled="true" selected="true">Product Name</option>--}}
                                    {{--</select>--}}

                                </div>

                                {{-- TODO: Add number of phases to migration? --}}
                                <div class="form-group">
                                    {!! Form::label('phase', 'Phase:')!!}
                                    {!! Form::number('phase', null, ['class'=>'form-control']) !!}
                                </div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dynamic_field">
                                    <tr>
                                        <td>{!! Form::text('plot_name', null, ['class'=>'form-control name_list', 'name'=>'plot_name[]', 'placeholder' => 'Plot name']) !!}</td>
                                        <td>{!! Form::number('sqft', null, ['class'=>'form-control name_list', 'name' => 'sqft[]', 'placeholder' => 'SqFt']) !!}</td>
                                        <td>{!! Form::text('status', 'For Sale', ['class'=>'form-control name_list', 'placeholder' => 'Status']) !!}</td>
                                        {{--<td><input type="text" name="name[]" placeholder="Enter Plot Name" class="form-control name_list" /></td>--}}
                                        {{--<td><input type="text" name="sqft[]" placeholder="SqFt" class="form-control name_list" /></td>--}}
                                        {{--<td><input type="text" name="status[]" placeholder="Status" class="form-control name_list" /></td>--}}
                                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group">
                                {!! Form::submit('Create Plot', ['class'=>'btn btn-primary']) !!}
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
            $('.selectPlot').select2();

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

        var i=1;

        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('' +
                '<tr id="row'+i+'" class="dynamic-added">' +
                '   <td>{!! Form::text('plot_name', null, ['class'=>'form-control name_list', 'name'=>'plot_name[]', 'placeholder' => 'Plot name']) !!}</td>' +
                '   <td>{!! Form::number('sqft', null, ['class'=>'form-control name_list', 'name' => 'sqft[]', 'placeholder' => 'SqFt']) !!}</td>' +
                '   <td>{!! Form::text('status', 'For Sale', ['class'=>'form-control name_list', 'placeholder' => 'Status']) !!}</td>' +
                '   <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'
            );
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
        $(document).on('change', '.developmentSelect', function(){
           // console.log("Changed");

            var dev_id=$(this).val();
            // console.log(dev_id);
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
                        option +='<option value="" selected disabled>Choose House Type</option>';
                    }else{
                        option +='<option value="" selected disabled>No House types available - Create one!</option>';
                    }

                    for(var i = 0; i < data.length; i++){
                        option+='<option value="'+data[i].id+'">'+data[i].house_type_name+'</option>';
                    }


                    $(".houseTypeSelect").html(" ").append(option);

                    // console.log(option);

                },
                error: function () {
                    console.log("Failed...")
                }
            })
        });
    </script>
@endsection
